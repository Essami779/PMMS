<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamInvitationController extends Controller
{
    /**
     * إرسال دعوة انضمام لعضو جديد
     */
    public function send(Request $request, Team $team)
    {
        $user = Auth::user();
        if (!$team->isLeader($user)) {
            abort(403, 'فقط قائد الفريق يمكنه إرسال الدعوات');
        }

        $request->validate([
            'email' => ['required', 'email'],
            'role_in_team' => ['required', 'string', 'max:100'],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني للمدعو',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'role_in_team.required' => 'يرجى تحديد دور العضو المتوقع',
        ]);

        $email = strtolower(trim($request->email));

        // التحقق إن كان العضو موجوداً بالفعل في الفريق
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $team->members()->where('user_id', $existingUser->id)->exists()) {
            return back()->with('error', 'هذا المستخدم عضو مسجل في الفريق بالفعل.');
        }

        // التحقق إن كانت هناك دعوة معلقة سابقة
        $pending = TeamInvitation::where('team_id', $team->id)
            ->where('email', $email)
            ->where('status', 'pending')
            ->first();

        if ($pending) {
            return back()->with('info', 'توجد دعوة نشطة مسبقاً لهذا البريد الإلكتروني. يمكنك نسخ رابطها أدناه.');
        }

        $invitation = TeamInvitation::create([
            'team_id' => $team->id,
            'invited_by' => $user->id,
            'email' => $email,
            'role_in_team' => $request->role_in_team,
            'token' => Str::random(48),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        $inviteUrl = route('team.invitations.accept', ['token' => $invitation->token]);

        return redirect()->route('team.workspace')
            ->with('success', "تم إنشاء دعوة الانضمام بنجاح! رابط الدعوة: {$inviteUrl}");
    }

    /**
     * إلغاء دعوة معلقة
     */
    public function cancel(Team $team, TeamInvitation $invitation)
    {
        $user = Auth::user();
        if (!$team->isLeader($user)) {
            abort(403, 'غير مصرح لك بإلغاء هذه الدعوة');
        }

        $invitation->update(['status' => 'cancelled']);

        return redirect()->route('team.workspace')
            ->with('success', 'تم إلغاء الدعوة بنجاح.');
    }

    /**
     * قبول الدعوة عبر الرابط المباشر
     */
    public function accept($token)
    {
        $invitation = TeamInvitation::where('token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')
                ->with('error', 'رابط الدعوة غير صالح أو تم استخدامه مسبقاً.');
        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            return redirect()->route('dashboard')
                ->with('error', 'انتهت صلاحية رابط الدعوة هذا.');
        }

        $user = Auth::user();

        // إضافة العضو للفريق
        TeamMember::firstOrCreate([
            'team_id' => $invitation->team_id,
            'user_id' => $user->id,
        ], [
            'role_in_team' => $invitation->role_in_team ?? 'عضو فريق',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $invitation->update(['status' => 'accepted']);

        return redirect()->route('team.workspace')
            ->with('success', "مبارك! لقد انضممت بنجاح إلى فريق: {$invitation->team->name}");
    }

    /**
     * الانضمام السريع للفريق عبر رمز الدعوة (Invite Code)
     */
    public function joinByCode(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'invite_code' => ['required', 'string', 'min:6', 'max:12'],
        ], [
            'invite_code.required' => 'يرجى إدخال رمز انضمام الفريق (Code)',
        ]);

        $code = strtoupper(trim($request->invite_code));
        $team = Team::where('invite_code', $code)->first();

        if (!$team) {
            return back()->with('error', 'رمز الانضمام غير صحيح، يرجى التأكد من الرمز والمحاولة ثانية.');
        }

        if ($team->members()->where('user_id', $user->id)->exists()) {
            return redirect()->route('team.workspace')
                ->with('info', 'أنت بالفعل عضو في هذا الفريق.');
        }

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role_in_team' => 'عضو جديد',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        return redirect()->route('team.workspace')
            ->with('success', "تم الانضمام بنجاح إلى فريق: {$team->name}!");
    }
}

