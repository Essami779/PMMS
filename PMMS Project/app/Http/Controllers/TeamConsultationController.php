<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamConsultationController extends Controller
{
    /**
     * صفحة استشارات وخبراء وتوجيه المشروع
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team) {
            return redirect()->route('team.workspace')->with('error', 'يجب أن تكون ضمن فريق للوصول لمركز الاستشارات.');
        }

        $consultations = $team->consultations()
            ->with('requester')
            ->latest()
            ->get();

        $stats = [
            'total' => $consultations->count(),
            'scheduled' => $consultations->where('status', 'confirmed')->count(),
            'completed' => $consultations->where('status', 'completed')->count(),
            'pending' => $consultations->where('status', 'pending')->count(),
        ];

        // قائمة الاستشاريين المعتمدين والمتاحين لطلب جلسة
        $advisors = [
            [
                'name' => 'د. نبيل عبد الحكيم الشرعبي',
                'title' => 'استشاري أول نظم الذكاء الاصطناعي والحوسبة السحابية',
                'specialty' => 'الذكاء الاصطناعي وتعلم الآلة',
                'category' => 'technical',
                'rating' => 4.9,
                'avatar' => 'NS',
            ],
            [
                'name' => 'م. لمياء أنور السقاف',
                'title' => 'خبيرة الأمن السيبراني واختبار الاختراق والامتثال',
                'specialty' => 'الأمن السيبراني والشبكات',
                'category' => 'security',
                'rating' => 4.95,
                'avatar' => 'LS',
            ],
            [
                'name' => 'م. رياض فضل السامعي',
                'title' => 'معماري حلول سحابية وبنى تحتية DevOps & Kubernetes',
                'specialty' => 'الحوسبة السحابية والبنية التحتية',
                'category' => 'technical',
                'rating' => 4.85,
                'avatar' => 'RS',
            ],
            [
                'name' => 'أ. أروى عبد الرحمن الشوافي',
                'title' => 'مستشارة استراتيجيات المنتجات وتجربة المستخدم Product/UX',
                'specialty' => 'تصميم وتجربة المستخدم UI/UX',
                'category' => 'ux',
                'rating' => 4.9,
                'avatar' => 'AS',
            ],
            [
                'name' => 'د. حسام طارق المقطري',
                'title' => 'مستشار نمذجة الأعمال وجولات الاستثمار وعروض المستثمرين',
                'specialty' => 'نماذج الأعمال والتمويل الاستثماري',
                'category' => 'business',
                'rating' => 4.8,
                'avatar' => 'HM',
            ],
        ];

        $isLeader = $team->isLeader($user);

        return view('team.consultations', compact('team', 'consultations', 'stats', 'advisors', 'isLeader'));
    }

    /**
     * طلب استشارة جديدة
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team) {
            return redirect()->back()->with('error', 'لا يوجد فريق نشط.');
        }

        $validated = $request->validate([
            'consultant_name' => 'required|string|max:255',
            'consultant_title' => 'nullable|string|max:255',
            'topic' => 'required|string|max:255',
            'category' => 'required|string|in:technical,security,business,ux,legal',
            'description' => 'nullable|string|max:2000',
            'session_date' => 'nullable|date',
            'meeting_link' => 'nullable|url|max:500',
        ]);

        $team->consultations()->create([
            'requested_by' => $user->id,
            'consultant_name' => $validated['consultant_name'],
            'consultant_title' => $validated['consultant_title'] ?? 'مستشار معتمد',
            'topic' => $validated['topic'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'status' => !empty($validated['session_date']) ? 'confirmed' : 'pending',
            'session_date' => $validated['session_date'] ?? null,
            'meeting_link' => $validated['meeting_link'] ?? null,
        ]);

        return redirect()->route('team.consultations')->with('success', 'تم تسجيل طلب الاستشارة وجدولتها بنجاح.');
    }

    /**
     * تحديث جلسة الاستشارة أو توثيق التوصيات
     */
    public function update(Request $request, TeamConsultation $consultation)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team || $consultation->team_id !== $team->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'session_date' => 'nullable|date',
            'meeting_link' => 'nullable|url|max:500',
            'recommendations' => 'nullable|string|max:3000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $consultation->update($validated);

        return redirect()->route('team.consultations')->with('success', 'تم تحديث بيانات الاستشارة والتوصيات.');
    }

    /**
     * إلغاء جلسة استشارة
     */
    public function destroy(TeamConsultation $consultation)
    {
        $user = Auth::user();
        $team = $user->currentTeam();

        if (!$team || $consultation->team_id !== $team->id) {
            abort(403);
        }

        $consultation->delete();

        return redirect()->route('team.consultations')->with('success', 'تم حذف جلسة الاستشارة بنجاح.');
    }
}

