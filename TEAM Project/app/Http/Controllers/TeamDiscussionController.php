<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamDiscussion;
use App\Models\TeamDiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamDiscussionController extends Controller
{
    /**
     * صفحة غرفة العمليات ونقاشات المشروع (War Room Discussions)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team) {
            return redirect()->route('team.workspace')->with('error', 'يجب أن تكون ضمن فريق للوصول لغرفة العمليات.');
        }

        $discussions = $team->discussions()
            ->with(['author.profile', 'replies.author.profile'])
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();

        $stats = [
            'total' => $discussions->count(),
            'pinned' => $discussions->where('is_pinned', true)->count(),
            'blockers' => $discussions->where('category', 'blocker')->count(),
            'replies' => $discussions->sum('replies_count'),
        ];

        $isLeader = $team->isLeader($user);

        return view('team.discussions', compact('team', 'discussions', 'stats', 'isLeader'));
    }

    /**
     * نشر موضوع نقاش جديد في غرفة العمليات
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team) {
            return redirect()->back()->with('error', 'لا يوجد فريق نشط.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'category' => 'required|string|in:general,architecture,blocker,announcement,security',
            'is_pinned' => 'nullable|boolean',
        ]);

        $team->discussions()->create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'is_pinned' => $team->isLeader($user) && ($request->boolean('is_pinned') ?? false),
        ]);

        return redirect()->route('team.discussions')->with('success', 'تم نشر موضوع النقاش في غرفة العمليات.');
    }

    /**
     * إضافة رد ومداخلة على موضوع نقاش
     */
    public function reply(Request $request, TeamDiscussion $discussion)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team || $discussion->team_id !== $team->id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:3000',
        ]);

        $discussion->replies()->create([
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        $discussion->increment('replies_count');

        return redirect()->route('team.discussions')->with('success', 'تمت إضافة مشاركتك بنجاح.');
    }

    /**
     * تثبيت / إلغاء تثبيت موضوع في قمة غرفة العمليات
     */
    public function togglePin(TeamDiscussion $discussion)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team || !$team->isLeader($user) || $discussion->team_id !== $team->id) {
            abort(403);
        }

        $discussion->update([
            'is_pinned' => !$discussion->is_pinned,
        ]);

        return redirect()->route('team.discussions')->with('success', $discussion->is_pinned ? 'تم تثبيت الموضوع في قمة الغرفة.' : 'تم إلغاء التثبيت.');
    }

    /**
     * حذف موضوع نقاش
     */
    public function destroy(TeamDiscussion $discussion)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team || $discussion->team_id !== $team->id) {
            abort(403);
        }

        if (!$team->isLeader($user) && $discussion->user_id !== $user->id) {
            abort(403);
        }

        $discussion->delete();

        return redirect()->route('team.discussions')->with('success', 'تم حذف الموضوع بنجاح.');
    }
}

