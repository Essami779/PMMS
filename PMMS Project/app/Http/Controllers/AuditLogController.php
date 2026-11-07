<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

use App\Models\User;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['causer', 'subject'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('log_name', 'like', "%{$search}%")
                  ->orWhere('properties', 'like', "%{$search}%")
                  ->orWhereHas('causer', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $totalCount = (clone $query)->count();

        // عدد السطور (محدد أو إظهار الكل)
        $perPageParam = $request->input('per_page', '20');
        if ($perPageParam === 'all' || $perPageParam === '-1') {
            $perPage = max(1, $totalCount);
        } else {
            $perPage = in_array((int)$perPageParam, [10, 15, 20, 25, 50, 100, 250, 500]) ? (int)$perPageParam : 20;
        }

        $activities = $query->paginate($perPage)->appends($request->query());

        $logNames = Activity::distinct()->pluck('log_name')->filter()->values();
        $allUsers = User::orderBy('name')->get();

        return view('audit.index', compact('activities', 'logNames', 'allUsers', 'perPageParam'));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('audit.index')->with('success', 'تم حذف سجل التدقيق بنجاح.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = collect($request->input('ids', []))
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int)$id)
            ->unique();

        if ($ids->isEmpty()) {
            return redirect()->route('audit.index')->with('error', 'لم يتم تحديد أي سجلات للحذف.');
        }

        Activity::whereIn('id', $ids)->delete();

        return redirect()->route('audit.index')
            ->with('success', 'تم حذف ' . $ids->count() . ' سجل من سجل التدقيق بنجاح.');
    }
}
