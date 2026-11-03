<?php

namespace App\Traits;

use App\Models\Memo;
use App\Models\MemoAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesAttachmentNaming
{
    /**
     * Generate physical filename and UI display name for an attachment.
     *
     * Physical Format on Disk: [MEMO_NUMBER]_[MEMO_SUBJECT]_[SEQ].[EXT]
     * UI Display Format:       [MEMO_NUMBER] - [MEMO_SUBJECT] ([SEQ]).[EXT]
     */
    protected function generateAttachmentNaming(Memo $memo, string $extension, int $seq, ?string $customName = null, bool $isScanned = false): array
    {
        $folder = 'attachments/' . date('Y/m');

        // Clean memo number for prefix
        $cleanMemoNum = preg_replace('/[^\w\d\-]/u', '_', $memo->memo_number);

        // Base title text (custom name if supplied, or memo subject)
        $baseText = !empty($customName) ? trim($customName) : trim($memo->subject);

        // Clean double extension artifacts
        $baseText = preg_replace('/(\.(webp|pdf|png|jpg|jpeg|doc|docx))+$/i', '', $baseText);

        // Strip memo number prefix if user input already includes it (prevent doubling)
        if ($memo) {
            $memoNumPattern = preg_quote($memo->memo_number, '/');
            $baseText = preg_replace('/^' . $memoNumPattern . '[\s\-_]*/i', '', $baseText);
            $cleanMemoNumStr = preg_replace('/[^\w\d\-]/u', '_', $memo->memo_number);
            $baseText = preg_replace('/^' . preg_quote($cleanMemoNumStr, '/') . '[\s\-_]*/i', '', $baseText);
        }

        // Clean sequence numbers like (1) or _1 at the end
        $baseText = preg_replace('/\s*\(\d+\)$/', '', $baseText);
        $baseText = preg_replace('/_\d+$/', '', $baseText);

        // Sanitize base title for Windows & Linux filesystems
        $cleanSubject = preg_replace('/[\/\\\:\*\?"<>\|]/u', '_', $baseText);
        $cleanSubject = preg_replace('/\s+/u', '_', trim($cleanSubject));
        $cleanSubject = Str::limit($cleanSubject, 70, '');

        $ext = strtolower(ltrim($extension, '.'));
        if ($ext === 'jpeg') $ext = 'jpg';
        if (empty($ext)) $ext = 'bin';

        // Guarantee uniqueness on disk
        $currentSeq = $seq;
        do {
            $scanTagDisk = $isScanned ? '_scan' : '';
            $physicalFileName = "{$cleanMemoNum}_{$cleanSubject}{$scanTagDisk}_{$currentSeq}.{$ext}";
            $filePath = "{$folder}/{$physicalFileName}";
            $exists = Storage::disk('public')->exists($filePath);
            if ($exists) {
                $currentSeq++;
            }
        } while ($exists);

        // Display Name for UI
        $displayTitle = Str::limit($baseText, 150, '');
        $scanTagUI = $isScanned ? ' - مسح ضوئي' : '';
        $originalName = "{$memo->memo_number} - {$displayTitle}{$scanTagUI} ({$currentSeq}).{$ext}";

        return [
            'folder' => $folder,
            'physical_filename' => $physicalFileName,
            'file_path' => $filePath,
            'original_name' => $originalName,
            'extension' => $ext,
        ];
    }

    /**
     * Rename physical file on disk and return updated database attributes when editing attachment.
     */
    protected function renameAttachmentPhysicalFile(MemoAttachment $attachment, string $newDisplayName): array
    {
        $oldPath = $attachment->file_path;
        $memo = $attachment->memo;

        // Clean double extension artifacts if present in user input (e.g. .webp.webp)
        $cleanInput = preg_replace('/(\.(webp|pdf|png|jpg|jpeg|doc|docx))+$/i', '', trim($newDisplayName));

        // Strip memo number prefix if user input already includes it (prevent doubling)
        if ($memo) {
            $memoNumPattern = preg_quote($memo->memo_number, '/');
            $cleanInput = preg_replace('/^' . $memoNumPattern . '[\s\-_]*/i', '', $cleanInput);
            $cleanMemoNumStr = preg_replace('/[^\w\d\-]/u', '_', $memo->memo_number);
            $cleanInput = preg_replace('/^' . preg_quote($cleanMemoNumStr, '/') . '[\s\-_]*/i', '', $cleanInput);
        }

        // Clean sequence numbers like (1) or _1 at the end
        $cleanInput = preg_replace('/\s*\(\d+\)$/', '', $cleanInput);
        $cleanInput = preg_replace('/_\d+$/', '', $cleanInput);

        // Extract extension from existing physical file or old file_path
        $ext = pathinfo($oldPath, PATHINFO_EXTENSION);
        if (empty($ext)) $ext = 'bin';

        $folder = dirname($oldPath);
        if (empty($folder) || $folder === '.') {
            $folder = 'attachments/' . ($attachment->created_at ? $attachment->created_at->format('Y/m') : date('Y/m'));
        }

        // Clean memo number
        $cleanMemoNum = $memo ? preg_replace('/[^\w\d\-]/u', '_', $memo->memo_number) : 'file';

        // Sanitize new title for filesystem
        $cleanSubject = preg_replace('/[\/\\\:\*\?"<>\|]/u', '_', $cleanInput);
        $cleanSubject = preg_replace('/\s+/u', '_', trim($cleanSubject));
        $cleanSubject = Str::limit($cleanSubject, 70, '');

        $seq = 1;
        do {
            $physicalFileName = "{$cleanMemoNum}_{$cleanSubject}_{$seq}.{$ext}";
            $newPath = "{$folder}/{$physicalFileName}";

            if ($newPath === $oldPath) {
                break;
            }
            $exists = Storage::disk('public')->exists($newPath);
            if ($exists) {
                $seq++;
            }
        } while ($exists);

        // Perform physical rename on disk if file exists and path changed
        if ($newPath !== $oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->makeDirectory($folder);
            Storage::disk('public')->move($oldPath, $newPath);
        }

        // Build clean display name for UI
        $finalSubject = trim($cleanInput);
        $finalDisplayName = $memo ? "{$memo->memo_number} - {$finalSubject} ({$seq}).{$ext}" : "{$finalSubject} ({$seq}).{$ext}";

        return [
            'file_name' => $physicalFileName,
            'file_path' => $newPath,
            'original_name' => $finalDisplayName,
        ];
    }
}
