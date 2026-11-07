<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Governorate;
use App\Models\Currency;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    /**
     * Supported trashed models mapping.
     */
    protected array $models = [
        'units' => Unit::class,
        'governorates' => Governorate::class,
        'currencies' => Currency::class,
    ];

    /**
     * Display the unified system trash hub with tabs for each module.
     */
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'all');
        $search = trim($request->input('search', ''));
        $perPage = (int) $request->input('per_page', 15);
        if ($perPage < 5 || $perPage > 200) {
            $perPage = 15;
        }

        // Count deleted records across all system modules
        $counts = [
            'units' => Unit::onlyTrashed()->count(),
            'governorates' => Governorate::onlyTrashed()->count(),
            'currencies' => Currency::onlyTrashed()->count(),
        ];
        $counts['all'] = array_sum($counts);

        // Fetch paginated data based on active tab
        $items = null;

        switch ($activeTab) {
            case 'units':
                $query = Unit::onlyTrashed()->latest('deleted_at');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
                }
                $items = $query->paginate($perPage)->withQueryString();
                break;

            case 'governorates':
                $query = Governorate::onlyTrashed()->latest('deleted_at');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
                }
                $items = $query->paginate($perPage)->withQueryString();
                break;

            case 'currencies':
                $query = Currency::onlyTrashed()->latest('deleted_at');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('code', 'like', "%{$search}%")
                          ->orWhere('symbol', 'like', "%{$search}%");
                }
                $items = $query->paginate($perPage)->withQueryString();
                break;

            case 'all':
            default:
                $query = Unit::onlyTrashed()->latest('deleted_at');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
                }
                $items = $query->paginate($perPage)->withQueryString();
                break;
        }

        return view('trash.index', compact('items', 'counts', 'activeTab', 'perPage'));
    }

    /**
     * Restore a single record.
     */
    public function restore(Request $request, string $type, int $id)
    {
        $modelClass = $this->models[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'نوع السجل غير صالح.');
        }

        $record = $modelClass::onlyTrashed()->find($id);
        if (!$record) {
            return back()->with('error', 'السجل المطلوب غير موجود في سلة المهملات.');
        }

        $record->restore();

        return back()->with('success', 'تم استعادة السجل بنجاح.');
    }

    /**
     * Permanently destroy a single record.
     */
    public function forceDestroy(Request $request, string $type, int $id)
    {
        $modelClass = $this->models[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'نوع السجل غير صالح.');
        }

        $record = $modelClass::onlyTrashed()->find($id);
        if (!$record) {
            return back()->with('error', 'السجل المطلوب غير موجود في سلة المهملات.');
        }

        $record->forceDelete();

        return back()->with('success', 'تم حذف السجل نهائياً من قاعدة البيانات.');
    }

    /**
     * Restore multiple records in bulk.
     */
    public function bulkRestore(Request $request, string $type)
    {
        $modelClass = $this->models[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'نوع السجل غير صالح.');
        }

        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'لم يتم تحديد أي سجلات للاستعادة.');
        }

        $restored = $modelClass::onlyTrashed()->whereIn('id', $ids)->restore();

        return back()->with('success', "تم استعادة {$restored} سجل/سجلات بنجاح.");
    }

    /**
     * Permanently destroy multiple records in bulk.
     */
    public function bulkForceDestroy(Request $request, string $type)
    {
        $modelClass = $this->models[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'نوع السجل غير صالح.');
        }

        $ids = $request->input('ids', []);
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'لم يتم تحديد أي سجلات للحذف النهائي.');
        }

        $count = $modelClass::onlyTrashed()->whereIn('id', $ids)->forceDelete();

        return back()->with('success', "تم حذف {$count} سجل/سجلات نهائياً من النظام.");
    }

    /**
     * Empty the trash for a specific tab or all.
     */
    public function emptyTrash(Request $request, string $type)
    {
        if ($type === 'all') {
            $totalDeleted = 0;
            foreach ($this->models as $modelClass) {
                $totalDeleted += $modelClass::onlyTrashed()->forceDelete();
            }
            return back()->with('success', "تم إفراغ سلة المهملات بالكامل وحذف {$totalDeleted} سجل نهائياً.");
        }

        $modelClass = $this->models[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'نوع السجل غير صالح.');
        }

        $count = $modelClass::onlyTrashed()->forceDelete();

        return back()->with('success', "تم إفراغ سلة المهملات لهذا القسم وحذف {$count} سجل نهائياً.");
    }
}
