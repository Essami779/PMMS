<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class BackupController extends Controller
{
    /**
     * المجلدات/المسارات التي يجب استثناؤها من النسخة الشاملة ZIP
     */
    protected array $excludedDirs = [
        'vendor',                // يُعاد تثبيته بـ composer install
        'node_modules',          // يُعاد تثبيته بـ npm install
        '.git',
        '.idea',
        '.vscode',
        'storage/app/backups',   // ملفات النسخ الاحتياطية القديمة (لا تضغط + حجمها ضخم)
    ];

    /**
     * Display a listing of database & project backups.
     */
    public function index()
    {
        $backupDir = storage_path('app/backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true, true);
        }

        $files = File::files($backupDir);
        $backups = [];

        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['sql', 'gz', 'zip'])) {
                $isFull = ($ext === 'zip');
                $mtime = $file->getMTime();
                $backups[] = [
                    'filename'        => $file->getFilename(),
                    'path'            => $file->getPathname(),
                    'size'            => $this->formatBytes($file->getSize()),
                    'raw_size'        => $file->getSize(),
                    'created_at'      => date('Y-m-d H:i:s', $mtime),
                    'created_date'    => date('Y-m-d', $mtime),
                    'created_time'    => date('h:i:s A', $mtime),
                    'human_time'      => \Carbon\Carbon::createFromTimestamp($mtime)->locale('ar')->diffForHumans(),
                    'timestamp'       => $mtime,
                    'is_full'         => $isFull,
                    'type_label'      => $isFull ? 'نسخة شاملة للمشروع (ZIP)' : 'نسخة قاعدة البيانات (SQL)',
                ];
            }
        }

        // Sort by newest first
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        // Storage & Health Summary
        $totalRawSize = array_sum(array_column($backups, 'raw_size'));
        $totalStorage = $this->formatBytes($totalRawSize);
        $fullCount = count(array_filter($backups, fn($b) => $b['is_full']));
        $sqlCount  = count(array_filter($backups, fn($b) => !$b['is_full']));
        
        $latestBackup = $backups[0] ?? null;
        $safetyStatus = 'critical';
        $safetyLabel  = 'لا توجد نسخ احتياطية محفوظة حالياً';
        $safetyColor  = 'rose';

        if ($latestBackup) {
            $hoursSince = (time() - $latestBackup['timestamp']) / 3600;
            if ($hoursSince < 24) {
                $safetyStatus = 'optimal';
                $safetyLabel  = 'مستوى الأمان ممتاز (تم أخذ نسخة في أقل من 24 ساعة)';
                $safetyColor  = 'emerald';
            } elseif ($hoursSince < 72) {
                $safetyStatus = 'good';
                $safetyLabel  = 'مستوى الأمان جيد (آخر نسخة خلال 3 أيام)';
                $safetyColor  = 'blue';
            } elseif ($hoursSince < 168) {
                $safetyStatus = 'warning';
                $safetyLabel  = 'تنبيه: مضى أكثر من 3 أيام على آخر نسخة';
                $safetyColor  = 'amber';
            } else {
                $safetyStatus = 'critical';
                $safetyLabel  = 'خطر: مضى أكثر من أسبوع دون إنشاء نسخة جديدة';
                $safetyColor  = 'rose';
            }
        }

        $backupSummary = [
            'total_count'   => count($backups),
            'full_count'    => $fullCount,
            'sql_count'     => $sqlCount,
            'total_storage' => $totalStorage,
            'latest'        => $latestBackup,
            'safety_status' => $safetyStatus,
            'safety_label'  => $safetyLabel,
            'safety_color'  => $safetyColor,
        ];

        // Fetch DB Statistics
        $dbStats = $this->getDatabaseStats();

        return view('backups.index', compact('backups', 'dbStats', 'backupSummary'));
    }

    /**
     * Upload an existing backup file (.sql or .zip) from user's machine.
     */
    public function uploadBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:524288', // max 512MB
        ]);

        try {
            $file = $request->file('backup_file');
            $ext  = strtolower($file->getClientOriginalExtension());

            if (!in_array($ext, ['sql', 'zip', 'gz'])) {
                return redirect()->route('backups.index')->with('error', 'صيغة الملف غير مدعومة. الصيغ المسموحة: .sql أو .zip فقط.');
            }

            $backupDir = storage_path('app/backups');
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true, true);
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName    = Str::slug($originalName, '_');
            $filename     = 'uploaded_' . $cleanName . '_' . date('Y-m-d_H-i-s') . '.' . $ext;

            $file->move($backupDir, $filename);

            return redirect()->route('backups.index')->with('success', "تم رفع وحفظ ملف النسخة الاحتياطية بنجاح: {$filename}");
        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'حدث خطأ أثناء رفع الملف: ' . $e->getMessage());
        }
    }

    /**
     * Create a new database backup.
     */
    public function store(Request $request)
    {
        try {
            $backupDir = storage_path('app/backups');

            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true, true);
            }

            $driver = DB::connection()->getDriverName();
            $rawDbName = config('database.connections.' . $driver . '.database', config('app.name', 'database'));
            $cleanDbName = Str::slug(str_replace([':', '\\', '/', '*', '?', '"', '<', '>', '|'], '_', (string) $rawDbName), '_');
            if (empty($cleanDbName)) {
                $cleanDbName = 'db_backup';
            }

            $filename = 'backup-' . $cleanDbName . '-' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = $backupDir . DIRECTORY_SEPARATOR . $filename;

            // Generate SQL Dump using PHP PDO
            $sqlContent = $this->generateSqlDump();
            File::put($filePath, $sqlContent);

            return redirect()->route('backups.index')->with('success', 'تم إنشاء نسخة قاعدة البيانات بنجاح: ' . $filename);

        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'حدث خطأ أثناء إنشاء النسخة الاحتياطية: ' . $e->getMessage());
        }
    }

    /**
     * Create a full project backup (Codebase + Uploaded Files + Database SQL Dump) in ZIP format.
     * Excludes: vendor/, node_modules/, .git/ and similar large auto-generated directories.
     */
    public function storeFullBackup(Request $request)
    {
        @set_time_limit(600);
        @ini_set('memory_limit', '1024M');

        try {
            $backupDir = storage_path('app/backups');

            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true, true);
            }

            $dbName      = config('database.connections.mysql.database', 'database');
            $dateStr     = date('Y-m-d_H-i-s');
            $zipFilename = 'full-backup-' . $dbName . '-' . $dateStr . '.zip';

            // استخدام دليل النظام المؤقت لمنع أي تعارض أثناء تجميع ملفات المشروع
            $tempZipPath  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'temp_full_backup_' . uniqid() . '.zip';
            $finalZipPath = $backupDir . DIRECTORY_SEPARATOR . $zipFilename;

            // توحيد المسارات لمقارنة صحيحة
            $normalizedTempZip  = $this->normalizePath($tempZipPath);
            $normalizedFinalZip = $this->normalizePath($finalZipPath);
            $basePath           = $this->normalizePath(base_path());

            $zip = new ZipArchive();
            if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return redirect()->route('backups.index')->with('error', 'فشل إنشاء ملف الأرشيف المضغوط ZIP.');
            }

            // 1. إضافة نسخة قاعدة البيانات SQL إلى جذر الـ ZIP
            $sqlContent = $this->generateSqlDump();
            $zip->addFromString('database_dump.sql', $sqlContent);

            // 2. تجميع ملفات المشروع مع استثناء المجلدات الضخمة غير الضرورية
            // نستخدم LEAVES_ONLY لاستهداف الملفات فقط دون المجلدات تجنباً لأخطاء الـ iterator
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(base_path(), RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($iterator as $item) {
                if (!$item->isFile() || !$item->isReadable()) continue;

                $filePath = $item->getRealPath();
                if (!$filePath) continue;

                $normalizedFilePath = $this->normalizePath($filePath);

                // تخطي ملف الـ ZIP نفسه إن وجد
                if ($normalizedFilePath === $normalizedTempZip || $normalizedFilePath === $normalizedFinalZip) {
                    continue;
                }

                // حساب المسار النسبي للملف
                $relativePath = substr($normalizedFilePath, strlen($basePath) + 1);
                if (empty($relativePath)) continue;

                // تخطي الملفات الواقعة داخل المجلدات المستثناة
                if ($this->isExcluded($relativePath)) continue;

                $zip->addFile($filePath, $relativePath);
            }

            $zip->close();

            // نقل ملف الـ ZIP النهائي المكتمل إلى مجلد النسخ الاحتياطية
            File::move($tempZipPath, $finalZipPath);

            return redirect()->route('backups.index')
                ->with('success', 'تم إنشاء النسخة الاحتياطية الشاملة (ZIP) للمشروع وقاعدة البيانات بنجاح: ' . $zipFilename);

        } catch (\Exception $e) {
            if (isset($tempZipPath) && File::exists($tempZipPath)) {
                @File::delete($tempZipPath);
            }
            return redirect()->route('backups.index')->with('error', 'حدث خطأ أثناء إنشاء النسخة الكلية: ' . $e->getMessage());
        }
    }

    /**
     * Download the specified backup file.
     */
    public function download($filename)
    {
        $safeFilename = basename($filename);
        $filePath     = storage_path('app/backups' . DIRECTORY_SEPARATOR . $safeFilename);

        if (!File::exists($filePath)) {
            return redirect()->route('backups.index')->with('error', 'الملف غير موجود أو تم حذفه.');
        }

        return Response::download($filePath);
    }

    /**
     * Delete the specified backup file.
     */
    public function destroy($filename)
    {
        $safeFilename = basename($filename);
        $filePath     = storage_path('app/backups' . DIRECTORY_SEPARATOR . $safeFilename);

        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->route('backups.index')->with('success', 'تم حذف النسخة الاحتياطية بنجاح.');
        }

        return redirect()->route('backups.index')->with('error', 'لم يتم العثور على الملف لحذفه.');
    }

    /**
     * Delete multiple selected backup files.
     */
    public function bulkDestroy(Request $request)
    {
        $filenames = $request->input('filenames', []);

        if (empty($filenames) || !is_array($filenames)) {
            return redirect()->route('backups.index')->with('error', 'يرجى تحديد نسخة احتياطية واحدة على الأقل للحذف.');
        }

        $deletedCount = 0;
        foreach ($filenames as $filename) {
            $safeFilename = basename($filename);
            $filePath     = storage_path('app/backups' . DIRECTORY_SEPARATOR . $safeFilename);

            if (File::exists($filePath)) {
                File::delete($filePath);
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            return redirect()->route('backups.index')->with('success', "تم حذف $deletedCount من النسخ الاحتياطية المحددة بنجاح.");
        }

        return redirect()->route('backups.index')->with('error', 'لم يتم العثور على الملفات المحددة لحذفها.');
    }

    /**
     * Restore database from backup file (.sql or .zip).
     * Executes SQL statement-by-statement for reliability with large files.
     */
    public function restore($filename)
    {
        try {
            $safeFilename = basename($filename);
            $filePath     = storage_path('app/backups' . DIRECTORY_SEPARATOR . $safeFilename);

            if (!File::exists($filePath)) {
                return redirect()->route('backups.index')->with('error', 'الملف المطلوب غير موجود.');
            }

            $ext = strtolower(pathinfo($safeFilename, PATHINFO_EXTENSION));

            if ($ext === 'zip') {
                $zip = new ZipArchive();
                if ($zip->open($filePath) === true) {
                    $sqlContent = $zip->getFromName('database_dump.sql');
                    $zip->close();
                    if ($sqlContent === false) {
                        return redirect()->route('backups.index')->with('error', 'لم يتم العثور على ملف قاعدة البيانات (database_dump.sql) داخل حزمة ZIP.');
                    }
                } else {
                    return redirect()->route('backups.index')->with('error', 'فشل فتح ملف الأرشيف ZIP.');
                }
            } else {
                $sqlContent = File::get($filePath);
            }

            $pdo = DB::connection()->getPdo();

            // تعيين الترميز أولاً لضمان صحة البيانات العربية
            $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
            $pdo->exec("SET SQL_MODE='';");

            // تقسيم SQL إلى جمل منفردة وتنفيذ كل جملة على حدة
            $errors = $this->executeSqlStatements($pdo, $sqlContent);

            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");

            if (!empty($errors)) {
                $errorSummary = implode(' | ', array_slice($errors, 0, 3));
                return redirect()->route('backups.index')
                    ->with('error', 'تمت الاستعادة جزئياً مع بعض الأخطاء: ' . $errorSummary);
            }

            return redirect()->route('backups.index')->with('success', 'تمت استعادة قاعدة البيانات بنجاح من النسخة: ' . $safeFilename);

        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'حدث خطأ أثناء استعادة النسخة الاحتياطية: ' . $e->getMessage());
        }
    }

    /**
     * Generate complete MySQL SQL Dump using PDO.
     * Includes proper charset/collation headers for Arabic data support.
     */
    protected function generateSqlDump(): string
    {
        $driver = DB::connection()->getDriverName();
        $dbName = config('database.connections.' . $driver . '.database', config('app.name', 'database'));

        if ($driver === 'sqlite') {
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $sql = "-- ========================================================\n";
            $sql .= "-- Database Backup: {$dbName}\n";
            $sql .= "-- Date & Time: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Application: " . config('app.name', 'Laravel Dashboard') . "\n";
            $sql .= "-- ========================================================\n\n";
            foreach ($tables as $t) {
                $tableName = $t->name;
                $sql .= "-- Table: {$tableName}\n";
            }
            return $sql;
        }

        $pdo = DB::connection()->getPdo();

        // تعيين الترميز للاتصال
        $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;");

        $tables = [];
        $query  = $pdo->query('SHOW TABLES');
        while ($row = $query->fetch(\PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        $sql  = "-- ========================================================\n";
        $sql .= "-- Database Backup: {$dbName}\n";
        $sql .= "-- Date & Time: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Application: " . config('app.name', 'Laravel Dashboard') . "\n";
        $sql .= "-- ========================================================\n\n";

        // إعدادات الترميز والوضع - ضرورية لصحة البيانات العربية
        $sql .= "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sql .= "SET time_zone = \"+00:00\";\n\n";

        foreach ($tables as $table) {
            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "-- Structure for table `{$table}`\n";
            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

            $createRow      = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            $createTableSql = $createRow['Create Table'] ?? reset($createRow);
            $sql           .= $createTableSql . ";\n\n";

            $sql .= "-- Dumping data for table `{$table}`\n";

            // قراءة البيانات صفاً بصف لتجنب نفاد الذاكرة في الجداول الكبيرة
            $stmt = $pdo->query("SELECT * FROM `{$table}`");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);

            $rowBuffer = [];
            $columns   = null;

            while ($row = $stmt->fetch()) {
                if ($columns === null) {
                    $columns = array_keys($row);
                }

                $escapedValues = array_map(function ($val) use ($pdo) {
                    if ($val === null) return 'NULL';
                    return $pdo->quote($val);
                }, array_values($row));

                $rowBuffer[] = "(" . implode(', ', $escapedValues) . ")";

                // كتابة كل 100 سجل دفعة واحدة لتحسين الأداء
                if (count($rowBuffer) >= 100) {
                    $sql .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES\n";
                    $sql .= implode(",\n", $rowBuffer) . ";\n\n";
                    $rowBuffer = [];
                }
            }

            // كتابة الصفوف المتبقية
            if (!empty($rowBuffer) && $columns !== null) {
                $sql .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES\n";
                $sql .= implode(",\n", $rowBuffer) . ";\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $sql;
    }

    /**
     * Execute SQL content statement by statement.
     * Returns array of error messages (empty if all succeeded).
     */
    protected function executeSqlStatements(\PDO $pdo, string $sqlContent): array
    {
        $errors     = [];
        $delimiter  = ';';
        $statements = [];
        $current    = '';
        $inString   = false;
        $stringChar = '';

        // تقسيم SQL بشكل ذكي مع مراعاة النصوص المحاطة بعلامات الاقتباس
        $len = strlen($sqlContent);
        for ($i = 0; $i < $len; $i++) {
            $char = $sqlContent[$i];

            if ($inString) {
                $current .= $char;
                if ($char === $stringChar && ($i === 0 || $sqlContent[$i - 1] !== '\\')) {
                    $inString = false;
                }
            } else {
                if ($char === "'" || $char === '"' || $char === '`') {
                    $inString   = true;
                    $stringChar = $char;
                    $current   .= $char;
                } elseif ($char === $delimiter) {
                    $stmt = trim($current);
                    if (!empty($stmt)) {
                        $statements[] = $stmt;
                    }
                    $current = '';
                } elseif ($char === '-' && isset($sqlContent[$i + 1]) && $sqlContent[$i + 1] === '-') {
                    // تخطي التعليقات السطرية --
                    while ($i < $len && $sqlContent[$i] !== "\n") {
                        $i++;
                    }
                } else {
                    $current .= $char;
                }
            }
        }

        // الجملة الأخيرة إن لم تنته بـ ;
        $stmt = trim($current);
        if (!empty($stmt)) {
            $statements[] = $stmt;
        }

        foreach ($statements as $statement) {
            // تخطي التعليقات والأسطر الفارغة
            if (str_starts_with(ltrim($statement), '--') || empty(trim($statement))) {
                continue;
            }

            try {
                $pdo->exec($statement);
            } catch (\PDOException $e) {
                // تسجيل الخطأ لكن الاستمرار في التنفيذ
                $errors[] = substr($statement, 0, 80) . '... => ' . $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Check if a relative path starts with an excluded directory.
     * Supports both top-level dirs ('vendor') and sub-paths ('storage/app/backups').
     */
    protected function isExcluded(string $relativePath): bool
    {
        // توحيد الفواصل لضمان المقارنة الصحيحة على Windows
        $normalizedRelative = str_replace('\\', '/', $relativePath);

        foreach ($this->excludedDirs as $dir) {
            $normalizedDir = str_replace('\\', '/', $dir);
            // يبدأ المسار بـ «مجلد_مستثنى/»
            if (str_starts_with($normalizedRelative, $normalizedDir . '/')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Normalize a filesystem path to use forward slashes (lowercase on Windows).
     */
    protected function normalizePath(string $path): string
    {
        return rtrim(str_replace('\\', '/', $path), '/');
    }

    /**
     * Get Database Information and Statistics.
     */
    protected function getDatabaseStats(): array
    {
        $dbName = config('database.connections.mysql.database', 'secretariat');

        try {
            $tables     = DB::select('SHOW TABLE STATUS');
            $tableCount = count($tables);
            $totalSize  = 0;
            $totalRows  = 0;

            foreach ($tables as $t) {
                $totalSize += ($t->Data_length + $t->Index_length);
                $totalRows += $t->Rows;
            }

            return [
                'db_name'     => $dbName,
                'table_count' => $tableCount,
                'total_rows'  => number_format($totalRows),
                'total_size'  => $this->formatBytes($totalSize),
            ];
        } catch (\Exception $e) {
            return [
                'db_name'     => $dbName,
                'table_count' => 0,
                'total_rows'  => 0,
                'total_size'  => '—',
            ];
        }
    }

    /**
     * Format bytes to human readable format.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
