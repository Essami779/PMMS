<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\MemberProfile;
use App\Models\TeamStandup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamWorkspaceController extends Controller
{
    /**
     * مساحة عمل الفريق ولوحة تحكم القائد
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team) {
            return view('team.workspace', [
                'hasTeam' => false,
                'team' => null,
            ]);
        }

        // تحميل العلاقات
        $team->load([
            'leader.profile',
            'members.profile',
            'invitations' => function ($query) {
                $query->latest();
            },
            'tasks' => function ($query) {
                $query->with('assignee')->latest();
            },
            'standups.user',
        ]);

        $isLeader = $team->isLeader($user);

        // إحصائيات سريعة للوحة القيادة
        $totalMembers = $team->members->count();
        $tasksTotal = $team->tasks->count();
        $tasksDone = $team->tasks->where('status', 'done')->count();
        $tasksInProgress = $team->tasks->where('status', 'in_progress')->count();
        $tasksReview = $team->tasks->where('status', 'review')->count();
        $tasksTodo = $team->tasks->where('status', 'todo')->count();
        $pendingInvites = $team->invitations->where('status', 'pending')->count();

        $categories = [
            'الذكاء الاصطناعي وتطبيقات الويب',
            'إنترنت الأشياء والنظم المدمجة',
            'الأمن السيبراني والشبكات',
            'التقنيات الطبية والصحية',
            'حلول الأعمال والتجارة الإلكترونية',
            'الأنظمة الجغرافية والخرائط (GIS)',
        ];

        return view('team.workspace', compact(
            'team',
            'isLeader',
            'user',
            'totalMembers',
            'tasksTotal',
            'tasksDone',
            'tasksInProgress',
            'tasksReview',
            'tasksTodo',
            'pendingInvites',
            'categories'
        ))->with('hasTeam', true);
    }

    /**
     * تأسيس وإنشاء فريق جديد
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'project_title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['required', 'string', 'max:100'],
            'university' => ['required', 'string', 'max:150'],
            'department' => ['nullable', 'string', 'max:150'],
            'github_repo' => ['nullable', 'url', 'max:255'],
        ], [
            'name.required' => 'يرجى إدخال اسم الفريق',
            'project_title.required' => 'يرجى إدخال عنوان فكرة مشروع التخرج',
            'category.required' => 'يرجى اختيار تخصص ومجال المشروع',
            'university.required' => 'يرجى تحديد الجامعة أو الكلية',
        ]);

        $team = Team::create([
            'leader_id' => $user->id,
            'name' => $validated['name'],
            'project_title' => $validated['project_title'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'university' => $validated['university'],
            'department' => $validated['department'] ?? 'كلية الحاسوب وتكنولوجيا المعلومات',
            'github_repo' => $validated['github_repo'] ?? null,
            'invite_code' => strtoupper(Str::random(8)),
            'status' => 'in_progress',
            'progress_percentage' => 15,
        ]);

        // إضافة القائد كأول عضو في الفريق تلقائياً
        TeamMember::firstOrCreate([
            'team_id' => $team->id,
            'user_id' => $user->id,
        ], [
            'role_in_team' => 'قائد ومؤسس الفريق',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // إنشاء ملف السيرة الذاتية إن لم يكن موجوداً
        MemberProfile::firstOrCreate(['user_id' => $user->id], [
            'job_title' => 'قائد الفريق ومطور برمجيات',
            'major' => 'علوم حاسوب / هندسة برمجيات',
            'skills' => 'إدارة المشاريع, هندسة البرمجيات, مراجعة الأكواد',
        ]);

        return redirect()->route('team.workspace')
            ->with('success', 'تم تأسيس فريقك بنجاح! مرحباً بك في مركز قيادة الفريق.');
    }

    /**
     * تحديث بيانات الفريق وإعدادات المشروع
     */
    public function update(Request $request, Team $team)
    {
        $user = Auth::user();
        if (!$team->isLeader($user)) {
            abort(403, 'غير مصرح لك بتعديل بيانات الفريق');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'project_title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['required', 'string', 'max:100'],
            'university' => ['required', 'string', 'max:150'],
            'department' => ['nullable', 'string', 'max:150'],
            'github_repo' => ['nullable', 'url', 'max:255'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'string', 'in:ideation,in_progress,under_review,completed'],
        ]);

        $team->update($validated);

        return redirect()->route('team.workspace')
            ->with('success', 'تم تحديث بيانات الفريق والمشروع بنجاح.');
    }

    /**
     * تحديث دور العضو داخل الفريق من قِبل القائد
     */
    public function updateMemberRole(Request $request, Team $team, User $member)
    {
        $user = Auth::user();
        if (!$team->isLeader($user)) {
            abort(403, 'فقط قائد الفريق يملك صلاحية تعديل الأدوار');
        }

        $request->validate([
            'role_in_team' => ['required', 'string', 'max:100'],
        ]);

        $teamMember = TeamMember::where('team_id', $team->id)
            ->where('user_id', $member->id)
            ->firstOrFail();

        $teamMember->update([
            'role_in_team' => $request->role_in_team,
        ]);

        return redirect()->route('team.workspace')
            ->with('success', "تم تحديث دور العضو ({$member->name}) بنجاح.");
    }

    /**
     * استبعاد عضو من الفريق
     */
    public function removeMember(Team $team, User $member)
    {
        $user = Auth::user();

        if (!$team->isLeader($user) && $user->id !== $member->id) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        if ($team->isLeader($member)) {
            return back()->with('error', 'لا يمكن استبعاد قائد ومؤسس الفريق. يجب نقل القيادة أولاً.');
        }

        TeamMember::where('team_id', $team->id)
            ->where('user_id', $member->id)
            ->delete();

        return redirect()->route('team.workspace')
            ->with('success', "تم استبعاد العضو ({$member->name}) من الفريق.");
    }

    /**
     * إضافة وقفة يومية أو تحديث سريع للفريق
     */
    public function storeStandup(Request $request, Team $team)
    {
        $user = Auth::user();

        if (!$team->members()->where('user_id', $user->id)->exists()) {
            abort(403, 'غير مصرح لك بنشر تحديثات في هذا الفريق');
        }

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'type' => ['nullable', 'string', 'in:update,milestone,blocker'],
        ], [
            'content.required' => 'يرجى كتابة نص التحديث أو الإنجاز اليومي',
        ]);

        TeamStandup::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
            'type' => $validated['type'] ?? 'update',
        ]);

        return redirect()->route('team.workspace')
            ->with('success', 'تمت إضافة التحديث اليومي في سجل الفريق بنجاح.');
    }

    /**
     * عرض تقرير المشرف الأكاديمي الرسمي بصيغة قابلة للطباعة والتصدير كـ PDF
     */
    public function report(Team $team)
    {
        $user = Auth::user();

        if (!$team->members()->where('user_id', $user->id)->exists()) {
            abort(403, 'غير مصرح لك باستعراض تقرير هذا الفريق');
        }

        $team->load([
            'leader.profile',
            'members.profile',
            'tasks' => function ($query) {
                $query->with('assignee')->latest();
            },
            'standups.user',
        ]);

        return view('team.report', compact('team', 'user'));
    }

    /**
     * تحديث السيرة الذاتية والملف الشخصي والـ CV للعضو الحالي
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'job_title' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'major' => ['nullable', 'string', 'max:150'],
            'university_id_number' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:500'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'cv_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'cv_file.mimes' => 'يجب أن يكون ملف السيرة الذاتية بصيغة PDF فقط.',
            'cv_file.max' => 'أقصى حجم لملف السيرة الذاتية هو 10 ميجابايت.',
        ]);

        $profile = MemberProfile::firstOrNew(['user_id' => $user->id]);

        $profile->job_title = $validated['job_title'] ?? $profile->job_title;
        $profile->phone = $validated['phone'] ?? $profile->phone;
        $profile->major = $validated['major'] ?? $profile->major;
        $profile->university_id_number = $validated['university_id_number'] ?? $profile->university_id_number;
        $profile->bio = $validated['bio'] ?? $profile->bio;
        $profile->skills = $validated['skills'] ?? $profile->skills;
        $profile->github_url = $validated['github_url'] ?? $profile->github_url;
        $profile->linkedin_url = $validated['linkedin_url'] ?? $profile->linkedin_url;
        $profile->portfolio_url = $validated['portfolio_url'] ?? $profile->portfolio_url;

        // رفع ملف الـ CV إن وجد
        if ($request->hasFile('cv_file')) {
            if ($profile->cv_path && Storage::disk('public')->exists($profile->cv_path)) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $path = $request->file('cv_file')->store('cvs', 'public');
            $profile->cv_path = $path;
        }

        $profile->save();

        return redirect()->route('team.workspace')
            ->with('success', 'تم تحديث سيرتك الذاتية وملفك المهني بنجاح.');
    }
}
