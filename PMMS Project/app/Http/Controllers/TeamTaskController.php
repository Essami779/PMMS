<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamTaskController extends Controller
{
    /**
     * إنشاء وإسناد مهمة جديدة
     */
    public function store(Request $request, Team $team)
    {
        $user = Auth::user();
        if (!$team->members()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'priority' => ['required', 'string', 'in:low,medium,high,urgent'],
            'due_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'in:todo,in_progress,review,done'],
        ], [
            'title.required' => 'يرجى كتابة عنوان المهمة',
        ]);

        $task = TeamTask::create([
            'team_id' => $team->id,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
            'status' => $validated['status'] ?? 'todo',
        ]);

        // تحديث نسبة إنجاز الفريق تلقائياً إذا رغب المستخدم
        $this->syncTeamProgress($team);

        return redirect()->route('team.workspace')
            ->with('success', 'تم إنشاء المهمة وإسنادها بنجاح.');
    }

    /**
     * تحديث حالة المهمة (قيد الانتظار، قيد التنفيذ، قيد المراجعة، مكتملة)
     */
    public function updateStatus(Request $request, Team $team, TeamTask $task)
    {
        $user = Auth::user();
        if (!$team->members()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'string', 'in:todo,in_progress,review,done'],
        ]);

        $task->update(['status' => $request->status]);

        $this->syncTeamProgress($team);

        return redirect()->route('team.workspace')
            ->with('success', "تم تحديث حالة المهمة ({$task->title}) بنجاح.");
    }

    /**
     * حذف مهمة
     */
    public function destroy(Team $team, TeamTask $task)
    {
        $user = Auth::user();
        if (!$team->isLeader($user)) {
            abort(403, 'فقط قائد الفريق يمكنه حذف المهام');
        }

        $task->delete();

        $this->syncTeamProgress($team);

        return redirect()->route('team.workspace')
            ->with('success', 'تم حذف المهمة بنجاح.');
    }

    /**
     * مزامنة وحساب نسبة الإنجاز تلقائياً بناء على المهام
     */
    protected function syncTeamProgress(Team $team)
    {
        $total = $team->tasks()->count();
        if ($total > 0) {
            $done = $team->tasks()->where('status', 'done')->count();
            $percentage = (int) round(($done / $total) * 100);
            $team->update(['progress_percentage' => $percentage]);
        }
    }
}

