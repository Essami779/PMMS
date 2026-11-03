@extends('layouts.app')

@section('title', 'مساحة عمل وإدارة الفريق والمشروع - منصة TEAM Hub')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-12" x-data="{
    activeTab: 'members',
    tasksView: 'kanban', // 'kanban' or 'table'
    docFilter: 'all',
    cvModal: false,
    selectedMember: null,
    inviteModal: false,
    taskModal: false,
    roleModal: false,
    standupModal: false,
    docModal: false,
    memberToEdit: null,
    copyFeedback: false,
    
    openCv(member) {
        this.selectedMember = member;
        this.cvModal = true;
    },
    editRole(member) {
        this.memberToEdit = member;
        this.roleModal = true;
    },
    copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        this.copyFeedback = true;
        setTimeout(() => this.copyFeedback = false, 2500);
    }
}">

    @if(!$hasTeam)
        <!-- ============================================================
             ONBOARDING: لا يوجد فريق بعد (تأسيس فريق أو انضمام)
             ============================================================ -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-950 border border-slate-800 p-8 sm:p-12 text-white shadow-2xl">
            <div class="absolute -right-24 -top-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-24 -bottom-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl mx-auto text-center space-y-4">
                <span class="px-4 py-1.5 rounded-full text-xs font-black bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 inline-block">
                    🚀 مرحباً بك في مساحة عمل وإدارة الفرق والمشاريع
                </span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                    ابدأ الآن: أسس فريق عملك الجديد أو انضم لفريق قائم
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                    يمكنك قيادة مشروعك التقني أو الريادي عبر إنشاء فريق وتوزيع المهام، أو الانضمام لفريق زميلك مباشرة عبر رمز الانضمام السريع.
                </p>

                <!-- Cards for two options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-8 text-right">
                    <!-- Option 1: Create Team -->
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-6 flex flex-col justify-between hover:bg-white/10 transition backdrop-blur-sm">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/20 border border-indigo-500/40 flex items-center justify-center text-2xl">
                                👑
                            </div>
                            <h3 class="text-lg font-black text-white">تأسيس فريق ومشروع جديد (كقائد)</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                سجل مشروعك، أدر أعضاء فريقك، استعرض ملفاتهم وخبراتهم، وزّع المهام، وتابع الإنجاز بالكامل عبر لوحة كانبان.
                            </p>
                        </div>
                        <button type="button" @click="$dispatch('open-create-team-modal')" 
                                class="mt-6 w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold text-xs shadow-lg shadow-indigo-600/30 transition flex items-center justify-center gap-2 cursor-pointer">
                            <span>تأسيس فريقي الآن</span>
                            <span>←</span>
                        </button>
                    </div>

                    <!-- Option 2: Join Team by Code -->
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-6 flex flex-col justify-between hover:bg-white/10 transition backdrop-blur-sm">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-2xl">
                                🤝
                            </div>
                            <h3 class="text-lg font-black text-white">الانضمام لفريق قائم</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                إذا كان مدير أو قائد الفريق قد زوّدك برمز انضمام (مثل NV-2026)، يمكنك إدخاله فوراً للالتحاق بالفريق.
                            </p>
                        </div>
                        <form action="{{ route('team.join.code') }}" method="POST" class="mt-6 space-y-2">
                            @csrf
                            <div class="flex gap-2">
                                <input type="text" name="invite_code" placeholder="رمز الانضمام (مثال: NV-2026)" required
                                       class="flex-1 px-3 py-2.5 rounded-xl bg-slate-900/90 border border-slate-700 text-xs text-white placeholder:text-slate-500 uppercase font-mono tracking-widest text-center focus:outline-none focus:border-emerald-500">
                                <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition cursor-pointer shrink-0">
                                    انضمام
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Team Modal for Onboarding -->
        <div x-data="{ showModal: false }" 
             @open-create-team-modal.window="showModal = true"
             x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="showModal = false" 
                     class="w-full max-w-2xl rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg font-bold">
                                💼
                            </span>
                            <div>
                                <h3 class="text-base font-black text-slate-900 dark:text-white">تأسيس وتسجيل فريق ومشروع جديد</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">ستكون أنت القائد والمدير المشرف على أعضاء هذا الفريق</p>
                            </div>
                        </div>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <form action="{{ route('team.store') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم الفريق أو Squad *</label>
                                <input type="text" name="name" placeholder="مثال: فريق تطوير النظم الذكية (NeuroVision)" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">مجال وتخصص المشروع *</label>
                                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    <option value="الذكاء الاصطناعي وتطبيقات الويب">الذكاء الاصطناعي وتطبيقات الويب</option>
                                    <option value="حلول السحاب والأنظمة المؤسسية">حلول السحاب والأنظمة المؤسسية</option>
                                    <option value="تطبيقات الهواتف والـ FinTech">تطبيقات الهواتف والـ FinTech</option>
                                    <option value="إنترنت الأشياء والنظم المدمجة">إنترنت الأشياء والنظم المدمجة</option>
                                    <option value="الأمن السيبراني وحماية الشبكات">الأمن السيبراني وحماية الشبكات</option>
                                    <option value="التجارة الإلكترونية والمنصات الذكية">التجارة الإلكترونية والمنصات الذكية</option>
                                    <option value="الأنظمة الجغرافية والخرائط (GIS)">الأنظمة الجغرافية والخرائط (GIS)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان المشروع أو المنتج *</label>
                            <input type="text" name="project_title" placeholder="مثال: منصة التشخيص الطبي المتقدم وتحليل الصور الإشعاعية" required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المنظمة / الشركة أو المؤسسة التابع لها *</label>
                                <input type="text" name="university" placeholder="اسم الشركة، المؤسسة، أو الجامعة" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">القسم أو القطاع</label>
                                <input type="text" name="department" placeholder="مثال: قطاع هندسة وتطوير النظم"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رابط مستودع الكود (GitHub / GitLab)</label>
                            <input type="url" name="github_repo" placeholder="https://github.com/organization/project"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">نبذة ووصف موجز عن المشروع والحل التقني</label>
                            <textarea name="description" rows="3" placeholder="اشرح باختصار مشكلة المشروع، القيمة المقدمة، والحل التقني المقترح..."
                                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500"></textarea>
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-800">
                            <button type="button" @click="showModal = false" 
                                    class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                                إلغاء
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition cursor-pointer">
                                حفظ وتأسيس الفريق 🚀
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @else
        <!-- ============================================================
             ACTIVE TEAM WORKSPACE: مساحة العمل ولوحة قيادة الفريق
             ============================================================ -->

        <!-- Top Team Navigation Bar -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-2.5 flex items-center justify-between flex-wrap gap-2 shadow-2xs">
            <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
                <a href="{{ route('team.workspace') }}" class="px-3.5 py-2 rounded-xl text-xs font-black bg-indigo-600 text-white shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>مساحة العمل ومتابعة الفريق</span>
                </a>
                <a href="{{ route('team.discussions') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>غرفة العمليات والنقاشات</span>
                </a>
                <a href="{{ route('team.consultations') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    <span>استشارات وخبراء المشروع</span>
                </a>
            </div>
            <a href="{{ route('team.report', $team) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة التقرير الشامل</span>
            </a>
        </div>

        <!-- 1. Executive Luxury Header Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-indigo-900/40 via-purple-900/20 to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
            <div class="absolute -left-16 -top-16 w-72 h-72 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -right-16 -bottom-16 w-72 h-72 bg-purple-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Info block -->
                <div class="space-y-3 max-w-3xl">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-50 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            {{ $team->category }}
                        </span>

                        @if($isLeader)
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500/15 text-amber-500 border border-amber-500/30 flex items-center gap-1.5">
                                <span>👑</span>
                                <span>أنت مدير ورئيس الفريق</span>
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-500/15 text-blue-400 border border-blue-500/30 flex items-center gap-1.5">
                                <span>👤</span>
                                <span>عضو في الفريق</span>
                            </span>
                        @endif

                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            🏢 {{ $team->university }}
                        </span>
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ $team->name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1 font-semibold leading-relaxed">
                            💡 المشروع: {{ $team->project_title }}
                        </p>
                    </div>

                    <!-- Progress Bar & Quick Metrics -->
                    <div class="pt-2 max-w-xl space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-500 dark:text-slate-400">نسبة التقدم وإنجاز دورة حياة المشروع:</span>
                            <span class="text-indigo-600 dark:text-indigo-400 font-black font-num">{{ $team->progress_percentage }}%</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-400 rounded-full transition-all duration-700" 
                                 style="width: {{ $team->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Actions & Code -->
                <div class="flex flex-col sm:flex-row lg:flex-col items-start lg:items-end gap-3 shrink-0">
                    <!-- Quick Invite Code Box -->
                    <div class="p-3.5 rounded-2xl bg-white/80 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700 shadow-xs flex items-center gap-3">
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 block font-bold">رمز الانضمام السريع للفريق:</span>
                            <span class="text-sm font-black font-mono tracking-wider text-indigo-600 dark:text-indigo-400">{{ $team->invite_code }}</span>
                        </div>
                        <button type="button" @click="copyToClipboard('{{ $team->invite_code }}')" 
                                class="p-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 hover:bg-indigo-100 text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 transition cursor-pointer"
                                title="نسخ الرمز">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                        </button>
                    </div>

                    <span x-show="copyFeedback" x-cloak class="text-[11px] font-bold text-emerald-400 animate-pulse">✓ تم نسخ الرمز للحافظة بنجاح!</span>

                    <!-- Action buttons -->
                    <div class="flex items-center flex-wrap gap-2">
                        <!-- Official Executive Report Button -->
                        <a href="{{ route('team.report', $team->id) }}" target="_blank"
                           class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/25 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>التقرير التنفيذي (طباعة / PDF)</span>
                        </a>

                        @if($isLeader)
                            <button type="button" @click="inviteModal = true"
                                    class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span>دعوة عضو</span>
                            </button>

                            <button type="button" @click="taskModal = true"
                                    class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>إضافة مهمة</span>
                            </button>
                        @endif

                        <button type="button" @click="docModal = true"
                                class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/30 transition flex items-center gap-1.5 cursor-pointer">
                            <span>📁 رفع وثيقة</span>
                        </button>

                        <button type="button" @click="standupModal = true"
                                class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md shadow-purple-600/30 transition flex items-center gap-1.5 cursor-pointer">
                            <span>💬 تحديث يومي</span>
                        </button>

                        @if($team->github_repo)
                            <a href="{{ $team->github_repo }}" target="_blank"
                               class="p-2.5 rounded-xl bg-slate-800/90 hover:bg-slate-700 border border-slate-700 text-slate-300 hover:text-white transition"
                               title="مستودع الكود على GitHub">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Professional Project Lifecycle Stepper (SDLC) -->
            <div class="mt-6 pt-5 border-t border-slate-200/40 dark:border-slate-800/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold text-slate-400">مراحل دورة حياة المشروع (Project Delivery Lifecycle):</span>
                    <span class="text-[11px] font-bold text-indigo-400">المرحلة الحالية: التطوير البرمجي والربط</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-center text-xs">
                    <div class="p-2.5 rounded-xl border {{ $team->progress_percentage >= 20 ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400 font-bold' : 'bg-slate-800/40 border-slate-700 text-slate-500' }}">
                        <span class="block text-sm">📋</span>
                        <span class="text-[10.5px] block mt-0.5">1. النطاق والمتطلبات</span>
                        <span class="text-[9px] font-num opacity-75">100% مكتمل</span>
                    </div>
                    <div class="p-2.5 rounded-xl border {{ $team->progress_percentage >= 40 ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400 font-bold' : 'bg-slate-800/40 border-slate-700 text-slate-500' }}">
                        <span class="block text-sm">🏗️</span>
                        <span class="text-[10.5px] block mt-0.5">2. التصميم والمعمارية</span>
                        <span class="text-[9px] font-num opacity-75">معتمد ✓</span>
                    </div>
                    <div class="p-2.5 rounded-xl border {{ $team->progress_percentage >= 45 ? 'bg-indigo-500/20 border-indigo-500/40 text-indigo-400 font-black ring-1 ring-indigo-500/30' : 'bg-slate-800/40 border-slate-700 text-slate-500' }}">
                        <span class="block text-sm">💻</span>
                        <span class="text-[10.5px] block mt-0.5">3. البرمجة والتطوير</span>
                        <span class="text-[9px] font-num text-amber-400">جاري العمل ⚡</span>
                    </div>
                    <div class="p-2.5 rounded-xl border {{ $team->progress_percentage >= 80 ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400 font-bold' : 'bg-slate-800/40 border-slate-700 text-slate-500' }}">
                        <span class="block text-sm">🛡️</span>
                        <span class="text-[10.5px] block mt-0.5">4. فحص الجودة والأمان</span>
                        <span class="text-[9px] font-num opacity-75">المرحلة القادمة</span>
                    </div>
                    <div class="p-2.5 rounded-xl border {{ $team->progress_percentage >= 100 ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400 font-bold' : 'bg-slate-800/40 border-slate-700 text-slate-500' }}">
                        <span class="block text-sm">🚀</span>
                        <span class="text-[10.5px] block mt-0.5">5. الإطلاق والتسليم</span>
                        <span class="text-[9px] font-num opacity-75">التسليم النهائي</span>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mt-6 pt-4 border-t border-slate-200/40 dark:border-slate-800/80 flex items-center gap-2 overflow-x-auto pb-1 custom-scrollbar">
                <button type="button" @click="activeTab = 'members'"
                        :class="activeTab === 'members' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>👥 أعضاء الفريق والخبرات</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-black/20 text-white font-num">{{ $totalMembers }}</span>
                </button>

                <button type="button" @click="activeTab = 'tasks'"
                        :class="activeTab === 'tasks' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>📋 لوحة المهام وكانبان</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-black/20 text-white font-num">{{ $tasksTotal }}</span>
                </button>

                <button type="button" @click="activeTab = 'vault'"
                        :class="activeTab === 'vault' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>📁 خزانة وثائق المشروع (Vault)</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-teal-500 text-white font-black font-num">{{ $docsCount }}</span>
                </button>

                <button type="button" @click="activeTab = 'standups'"
                        :class="activeTab === 'standups' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>💬 الوقفات والتحديثات اليومية</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-purple-500 text-white font-black font-num">{{ count($team->standups) }}</span>
                </button>

                <button type="button" @click="activeTab = 'invitations'"
                        :class="activeTab === 'invitations' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>✉️ إدارة الدعوات ورمز الانضمام</span>
                    @if($pendingInvites > 0)
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-amber-500 text-slate-950 font-black font-num">{{ $pendingInvites }}</span>
                    @endif
                </button>

                <button type="button" @click="activeTab = 'my_cv'"
                        :class="activeTab === 'my_cv' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <span>📄 ملفي المهني والسيرة الذاتية</span>
                </button>

                @if($isLeader)
                    <button type="button" @click="activeTab = 'project'"
                            :class="activeTab === 'project' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 cursor-pointer whitespace-nowrap">
                        <span>⚙️ إعدادات المشروع</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- 2. Quick Stat Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">إجمالي أعضاء الفريق</span>
                <div class="mt-1 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-slate-900 dark:text-white font-num">{{ $totalMembers }}</span>
                    <span class="text-xs text-indigo-500 font-bold">عضو نشط</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">المهام المكتملة</span>
                <div class="mt-1 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-num">{{ $tasksDone }} / {{ $tasksTotal }}</span>
                    <span class="text-xs text-emerald-500 font-bold">إنجاز</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">مخرجات المشروع المعتمدة</span>
                <div class="mt-1 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-teal-600 dark:text-teal-400 font-num">{{ $docsCount }}</span>
                    <span class="text-xs text-teal-500 font-bold">ملف بالخزانة</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">الدعوات المعلقة</span>
                <div class="mt-1 flex items-baseline justify-between">
                    <span class="text-2xl font-black text-purple-600 dark:text-purple-400 font-num">{{ $pendingInvites }}</span>
                    <span class="text-xs text-purple-500 font-bold">في انتظار القبول</span>
                </div>
            </div>
        </div>

        <!-- ============================================================
             TAB 1: MEMBERS ROSTER & INTERACTIVE PROFILE VIEWER
             ============================================================ -->
        <div x-show="activeTab === 'members'" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <div>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">قائمة أعضاء الفريق وملفات الخبرات</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">انقر على أي عضو لاستعراض سيرته الذاتية، مهاراته، روابط أعماله، ومراسلته فوراً.</p>
                </div>

                @if($isLeader)
                    <button type="button" @click="inviteModal = true"
                            class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition flex items-center gap-2 cursor-pointer self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>إضافة / دعوة عضو</span>
                    </button>
                @endif
            </div>

            <!-- Members Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($team->members as $member)
                    @php
                        $profile = $member->profile;
                        $skills = $profile?->skills_list ?? [];
                        $isThisMemberLeader = $team->isLeader($member);
                        $memberDataJson = json_encode([
                            'id' => $member->id,
                            'name' => $member->name,
                            'email' => $member->email,
                            'avatar' => $member->avatar_url,
                            'role_in_team' => $member->pivot->role_in_team ?? 'عضو فريق',
                            'job_title' => $profile?->job_title ?? 'مهندس برمجيات',
                            'phone' => $profile?->phone ?? 'غير محدد',
                            'major' => $profile?->major ?? 'هندسة برمجيات وتطوير نظم',
                            'university_id' => $profile?->university_id_number ?? 'MEM-' . $member->id . '00',
                            'gpa' => 'محترف متقدم (Senior)',
                            'bio' => $profile?->bio ?? 'عضو متميز في الفريق، يساهم في إنجاز مخرجات المشروع البرمجية والريادية بأعلى معايير الجودة.',
                            'skills' => $skills,
                            'github_url' => $profile?->github_url ?? 'https://github.com',
                            'linkedin_url' => $profile?->linkedin_url ?? 'https://linkedin.com',
                            'portfolio_url' => $profile?->portfolio_url,
                            'cv_url' => $profile?->cv_url,
                            'is_leader' => $isThisMemberLeader,
                        ]);
                    @endphp

                    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-indigo-500/40 transition-all duration-300 group">
                        <div class="space-y-4">
                            <!-- Member Header & Role Badge -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}"
                                             class="w-13 h-13 rounded-2xl object-cover ring-2 ring-indigo-500/30 group-hover:ring-indigo-500 transition">
                                        @if($isThisMemberLeader)
                                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center text-[10px] shadow-sm font-bold" title="قائد الفريق">👑</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                            {{ $member->name }}
                                        </h4>
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold mt-0.5">
                                            {{ $member->pivot->role_in_team ?? 'عضو فريق' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Options dropdown for leader -->
                                @if($isLeader && !$isThisMemberLeader)
                                    <div class="relative" x-data="{ menuOpen: false }">
                                        <button @click="menuOpen = !menuOpen" @click.outside="menuOpen = false"
                                                class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                        <div x-show="menuOpen" x-cloak
                                             class="absolute left-0 mt-1 w-44 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl py-1 z-20 text-xs">
                                            <button type="button" @click="editRole({{ $memberDataJson }}); menuOpen = false;"
                                                    class="w-full text-right px-3 py-2 text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 flex items-center gap-2">
                                                <span>✏️</span>
                                                <span>تعديل الدور في الفريق</span>
                                            </button>
                                            <form action="{{ route('team.members.remove', ['team' => $team->id, 'member' => $member->id]) }}" method="POST"
                                                  onsubmit="return confirm('هل أنت متأكد من رغبتك في استبعاد هذا العضو من الفريق؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-right px-3 py-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 flex items-center gap-2">
                                                    <span>🗑️</span>
                                                    <span>استبعاد من الفريق</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Member Job title & bio preview -->
                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 text-xs space-y-1">
                                <div class="text-[10px] text-slate-400 font-bold">المسمى المهني والخبرة:</div>
                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $profile?->job_title ?? 'مهندس برمجيات' }}</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">
                                    {{ $profile?->bio ?? 'متخصص في مجاله ويساهم في تطوير مخرجات المشروع بأعلى معايير الكفاءة.' }}
                                </div>
                            </div>

                            <!-- Skills preview tags -->
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold block mb-1.5">أبرز المهارات والتقنيات:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse(array_slice($skills, 0, 4) as $skill)
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200/50 dark:border-indigo-800/50">
                                            {{ $skill }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-slate-400 italic">لم تضف مهارات بعد</span>
                                    @endforelse
                                    @if(count($skills) > 4)
                                        <span class="px-1.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500">
                                            +{{ count($skills) - 4 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Action: Open Profile Viewer Modal -->
                        <div class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-2">
                            <span class="text-[10px] text-slate-400">انضم: {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->diffForHumans() : 'حديثاً' }}</span>
                            
                            <button type="button" 
                                    @click="openCv({{ $memberDataJson }})"
                                    class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-950/60 dark:to-purple-950/60 text-indigo-700 dark:text-indigo-300 hover:from-indigo-600 hover:to-indigo-700 hover:text-white dark:hover:text-white font-bold text-xs border border-indigo-200/60 dark:border-indigo-800/60 shadow-2xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer">
                                <span>استعراض الملف والـ CV</span>
                                <span>📄</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ============================================================
             TAB 2: VISUAL KANBAN BOARD & TASKS MONITORING
             ============================================================ -->
        <div x-show="activeTab === 'tasks'" class="space-y-4">
            <!-- Header & Switcher Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <div>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">لوحة المهام وكانبان التفاعلية</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">تتبع المهام في أعمدة بصرية متسلسلة مع إمكانية النقل الفوري وتحديث الحالات.</p>
                </div>

                <div class="flex items-center gap-2">
                    <div class="bg-slate-100 dark:bg-slate-800 p-1 rounded-xl flex items-center gap-1 border border-slate-200 dark:border-slate-700">
                        <button type="button" @click="tasksView = 'kanban'"
                                :class="tasksView === 'kanban' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-white shadow-xs font-black' : 'text-slate-500 hover:text-slate-700'"
                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                            <span>لوحة كانبان 🗂️</span>
                        </button>
                        <button type="button" @click="tasksView = 'table'"
                                :class="tasksView === 'table' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-white shadow-xs font-black' : 'text-slate-500 hover:text-slate-700'"
                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                            <span>جدول مسطح 📊</span>
                        </button>
                    </div>

                    @if($isLeader)
                        <button type="button" @click="taskModal = true"
                                class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>مهمة جديدة</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- View 1: 4-Column Visual Kanban Board -->
            <div x-show="tasksView === 'kanban'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $columns = [
                        ['id' => 'todo', 'title' => 'قيد الانتظار ⏳', 'color' => 'slate', 'bg' => 'bg-slate-500/10', 'border' => 'border-slate-500/20', 'text' => 'text-slate-600 dark:text-slate-400'],
                        ['id' => 'in_progress', 'title' => 'قيد التنفيذ ⚡', 'color' => 'amber', 'bg' => 'bg-amber-500/10', 'border' => 'border-amber-500/30', 'text' => 'text-amber-500'],
                        ['id' => 'review', 'title' => 'قيد المراجعة 🔍', 'color' => 'purple', 'bg' => 'bg-purple-500/10', 'border' => 'border-purple-500/30', 'text' => 'text-purple-400'],
                        ['id' => 'done', 'title' => 'مكتملة بنجاح ✓', 'color' => 'emerald', 'bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/30', 'text' => 'text-emerald-500'],
                    ];
                @endphp

                @foreach($columns as $col)
                    @php
                        $colTasks = $team->tasks->where('status', $col['id']);
                    @endphp
                    <div class="rounded-3xl bg-slate-50/70 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800 p-4 flex flex-col justify-between min-h-[420px]">
                        <div class="space-y-3">
                            <!-- Column Header -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $col['id'] === 'done' ? 'bg-emerald-500' : ($col['id'] === 'in_progress' ? 'bg-amber-500' : ($col['id'] === 'review' ? 'bg-purple-500' : 'bg-slate-400')) }}"></span>
                                    <h4 class="text-xs font-black text-slate-800 dark:text-slate-200">{{ $col['title'] }}</h4>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $col['bg'] }} {{ $col['text'] }} font-num">
                                    {{ count($colTasks) }}
                                </span>
                            </div>

                            <!-- Tasks List in Column -->
                            <div class="space-y-3">
                                @forelse($colTasks as $task)
                                    <div class="rounded-2xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-3.5 shadow-2xs hover:shadow-md transition space-y-2.5">
                                        <!-- Priority & Due Date -->
                                        <div class="flex items-center justify-between gap-2">
                                            @if($task->priority === 'urgent')
                                                <span class="px-2 py-0.5 rounded-md text-[9.5px] font-black bg-rose-500/15 text-rose-500 border border-rose-500/30">عاجل ⚡</span>
                                            @elseif($task->priority === 'high')
                                                <span class="px-2 py-0.5 rounded-md text-[9.5px] font-black bg-amber-500/15 text-amber-500 border border-amber-500/30">أولوية عالية 🔺</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-md text-[9.5px] font-bold bg-blue-500/15 text-blue-400">عادية</span>
                                            @endif

                                            <span class="text-[10px] text-slate-400 font-num">
                                                {{ $task->due_date ? $task->due_date->format('m/d') : 'مفتوح' }}
                                            </span>
                                        </div>

                                        <!-- Title & description -->
                                        <div>
                                            <h5 class="text-xs font-black text-slate-900 dark:text-white leading-snug">{{ $task->title }}</h5>
                                            @if($task->description)
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">{{ $task->description }}</p>
                                            @endif
                                        </div>

                                        <!-- Assignee & Move Actions Footer -->
                                        <div class="pt-2 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between gap-2">
                                            @if($task->assignee)
                                                <div class="flex items-center gap-1.5" title="{{ $task->assignee->name }}">
                                                    <img src="{{ $task->assignee->avatar_url }}" alt="{{ $task->assignee->name }}" class="w-5 h-5 rounded-full object-cover">
                                                    <span class="text-[10.5px] font-bold text-slate-600 dark:text-slate-300 truncate max-w-[80px]">{{ $task->assignee->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-slate-400 italic">غير مسند</span>
                                            @endif

                                            <!-- Move Status Dropdown Form -->
                                            <form action="{{ route('team.tasks.status', ['team' => $team->id, 'task' => $task->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                        class="text-[10px] font-bold rounded-lg px-1.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border-0 focus:ring-1 focus:ring-indigo-500 cursor-pointer">
                                                    <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>⏳ انتظار</option>
                                                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>⚡ تنفيذ</option>
                                                    <option value="review" {{ $task->status === 'review' ? 'selected' : '' }}>🔍 مراجعة</option>
                                                    <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>✓ إكمال</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-[11px] text-slate-400 italic rounded-2xl border border-dashed border-slate-300 dark:border-slate-800">
                                        لا توجد مهام هنا
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($isLeader)
                            <div class="pt-3 border-t border-slate-200/60 dark:border-slate-800/60 text-center">
                                <button type="button" @click="taskModal = true" class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    + إضافة مهمة بهذا العمود
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- View 2: Traditional Flat Table View -->
            <div x-show="tasksView === 'table'" class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-slate-50/75 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 text-xs font-bold border-b border-slate-200 dark:border-slate-800">
                                <th class="p-4">المهمة وموضوع الإنجاز</th>
                                <th class="p-4">العضو المكلف</th>
                                <th class="p-4">الأولوية</th>
                                <th class="p-4">موعد التسليم</th>
                                <th class="p-4">الحالة وسرعة الإنجاز</th>
                                @if($isLeader)
                                    <th class="p-4 text-center">إجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                            @forelse($team->tasks as $task)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-slate-900 dark:text-white">{{ $task->title }}</div>
                                        @if($task->description)
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-1">{{ $task->description }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if($task->assignee)
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $task->assignee->avatar_url }}" alt="{{ $task->assignee->name }}" class="w-6 h-6 rounded-full object-cover">
                                                <span class="font-bold text-slate-700 dark:text-slate-300">{{ $task->assignee->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic">غير مسندة</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if($task->priority === 'urgent')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500/15 text-rose-500 border border-rose-500/30">عاجل جداً ⚡</span>
                                        @elseif($task->priority === 'high')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500/15 text-amber-500 border border-amber-500/30">أولوية عالية 🔺</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/15 text-blue-400 border border-blue-500/30">متوسطة</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-slate-600 dark:text-slate-400 font-num">
                                        {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'مفتوح' }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <form action="{{ route('team.tasks.status', ['team' => $team->id, 'task' => $task->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-bold rounded-xl px-2.5 py-1.5 border transition cursor-pointer focus:outline-none 
                                                    {{ $task->status === 'done' ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-300 text-emerald-700 dark:text-emerald-300' : '' }}
                                                    {{ $task->status === 'in_progress' ? 'bg-amber-50 dark:bg-amber-950/60 border-amber-300 text-amber-700 dark:text-amber-300' : '' }}
                                                    {{ $task->status === 'review' ? 'bg-purple-50 dark:bg-purple-950/60 border-purple-300 text-purple-700 dark:text-purple-300' : '' }}
                                                    {{ $task->status === 'todo' ? 'bg-slate-100 dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400' : '' }}">
                                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>⚡ قيد التنفيذ</option>
                                                <option value="review" {{ $task->status === 'review' ? 'selected' : '' }}>🔍 قيد المراجعة</option>
                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>✓ مكتملة بنجاح</option>
                                            </select>
                                        </form>
                                    </td>
                                    @if($isLeader)
                                        <td class="p-4 text-center whitespace-nowrap">
                                            <form action="{{ route('team.tasks.destroy', ['team' => $team->id, 'task' => $task->id]) }}" method="POST"
                                                  onsubmit="return confirm('هل تريد حذف هذه المهمة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/40 transition cursor-pointer" title="حذف المهمة">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isLeader ? 6 : 5 }}" class="p-8 text-center text-slate-400 text-xs">
                                        لا توجد مهام مسجلة حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================================================
             TAB 3: PROJECT VAULT (خزانة وثائق ومخرجات المشروع)
             ============================================================ -->
        <div x-show="activeTab === 'vault'" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
                <div>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">خزانة مخرجات ووثائق المشروع (Project Deliverables Vault)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">مستندات المعمارية، المواصفات الفنية، عروض المستثمرين، وتقارير الفحص وضمان الجودة.</p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" @click="docModal = true"
                            class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/30 transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>رفع وثيقة جديدة</span>
                    </button>
                </div>
            </div>

            <!-- Documents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($team->documents as $doc)
                    <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-teal-500/40 transition-all duration-300 group">
                        <div class="space-y-3.5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-950/80 border border-teal-200 dark:border-teal-800 text-teal-600 dark:text-teal-400 flex items-center justify-center font-black text-xl">
                                    @if(in_array($doc->file_type, ['pdf']))
                                        📄
                                    @elseif(in_array($doc->file_type, ['pptx', 'ppt']))
                                        📊
                                    @elseif(in_array($doc->file_type, ['docx', 'doc']))
                                        📝
                                    @elseif(in_array($doc->file_type, ['zip', 'rar']))
                                        📦
                                    @else
                                        📁
                                    @endif
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800 font-num">
                                        {{ $doc->version }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 font-num">
                                        {{ $doc->formatted_size }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition leading-snug">
                                    {{ $doc->title }}
                                </h4>
                                @if($doc->description)
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">
                                        {{ $doc->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 text-[11px] flex items-center justify-between text-slate-500">
                                <span>رفع بواسطة: <strong class="text-slate-800 dark:text-slate-200">{{ $doc->uploader->name }}</strong></span>
                                <span class="font-num text-[10px]">{{ $doc->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>

                        <div class="mt-5 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                            <a href="{{ $doc->download_url }}" target="_blank"
                               class="px-4 py-2 rounded-xl bg-teal-50 dark:bg-teal-950/60 hover:bg-teal-600 hover:text-white text-teal-700 dark:text-teal-300 font-bold text-xs transition border border-teal-200 dark:border-teal-800 flex items-center gap-1.5 cursor-pointer">
                                <span>تحميل / معاينة</span>
                                <span>📥</span>
                            </a>

                            @if($isLeader || $doc->uploaded_by === $user->id)
                                <form action="{{ route('team.documents.destroy', ['team' => $team->id, 'document' => $doc->id]) }}" method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف من الخزانة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 rounded-xl transition" title="حذف الملف">
                                        🗑️
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center text-slate-400 text-xs rounded-3xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 space-y-2">
                        <div class="text-3xl">📁</div>
                        <p class="font-bold">لا توجد وثائق أو مخرجات مرفوعة في الخزانة حتى الآن.</p>
                        <p class="text-[11px]">يمكنك رفع وثائق المتطلبات، المخططات، العروض التقديمية، والتقارير الفنية المعتمدة للمشروع.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ============================================================
             TAB 4: STANDUPS & DAILY FEED (الوقفات والتحديثات اليومية)
             ============================================================ -->
        <div x-show="activeTab === 'standups'" class="space-y-6">
            <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">سجل الوقفات اليومية وملاحظات الفريق (Daily Standup)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">شارك ما أنجزته اليوم وما تعمل عليه لإبقاء مدير الفريق والزملاء على اطلاع دائم.</p>
                    </div>
                    <button type="button" @click="standupModal = true"
                            class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md shadow-purple-600/30 transition flex items-center gap-1.5 cursor-pointer">
                        <span>+ إضافة تحديث يومي</span>
                    </button>
                </div>

                <!-- Feed Stream -->
                <div class="space-y-4 pt-2">
                    @forelse($team->standups as $sd)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/70 dark:border-slate-700/60 flex items-start gap-3.5 transition hover:border-purple-500/40">
                            <img src="{{ $sd->user->avatar_url }}" alt="{{ $sd->user->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-purple-500/40">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-black text-slate-900 dark:text-white">{{ $sd->user->name }}</span>
                                        @if($team->isLeader($sd->user))
                                            <span class="text-[9.5px] px-2 py-0.2 rounded-full font-bold bg-amber-400 text-slate-950">👑 مدير الفريق</span>
                                        @endif
                                        @if($sd->type === 'milestone')
                                            <span class="text-[9.5px] px-2 py-0.2 rounded-full font-bold bg-emerald-500/20 text-emerald-400">🏆 محطة هامة</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-num">{{ $sd->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed font-semibold">
                                    {{ $sd->content }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-xs">
                            لم تُسجل أي وقفات يومية بعد. كن أول من يشارك إنجازه اليوم!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ============================================================
             TAB 5: INVITATIONS & QUICK JOIN CODE (إدارة الدعوات)
             ============================================================ -->
        <div x-show="activeTab === 'invitations'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Quick Join Code Banner -->
                <div class="rounded-3xl bg-gradient-to-br from-indigo-900 to-slate-900 border border-slate-800 p-6 text-white space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 inline-block">
                        🔑 رمز الانضمام السريع
                    </span>
                    <h3 class="text-lg font-black">شارك الرمز مع فريقك</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        يستطيع أي عضو أو زميل كتابة هذا الرمز مباشرة في حسابه للالتحاق بفريقك بضغطة زر واحدة.
                    </p>

                    <div class="p-4 rounded-2xl bg-black/40 border border-white/10 text-center space-y-2">
                        <span class="text-[10px] text-slate-400 uppercase tracking-widest block font-bold">Team Join Code</span>
                        <div class="text-3xl font-black font-mono tracking-widest text-amber-400">{{ $team->invite_code }}</div>
                    </div>

                    <button type="button" @click="copyToClipboard('{{ $team->invite_code }}')"
                            class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition cursor-pointer flex items-center justify-center gap-2">
                        <span>نسخ رمز الانضمام</span>
                        <span>📋</span>
                    </button>
                </div>

                <!-- Right: Send Email Invitation Form -->
                <div class="lg:col-span-2 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 space-y-4 shadow-xs">
                    <div class="border-b border-slate-200 dark:border-slate-800 pb-3">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">إرسال دعوة انضمام رسمية عبر البريد</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">سيتم توليد رابط فريد ومؤقت لتسجيل زميلك في الفريق مباشرة.</p>
                    </div>

                    @if($isLeader)
                        <form action="{{ route('team.invitations.send', $team->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني للعضو *</label>
                                    <input type="email" name="email" placeholder="teammate@company.com" required
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الدور المتوقع في الفريق *</label>
                                    <select name="role_in_team" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                        <option value="مطور واجهات أمامية (Front-End)">مطور واجهات أمامية (Front-End)</option>
                                        <option value="مطور خلفية وسيرفرات (Back-End)">مطور خلفية وسيرفرات (Back-End)</option>
                                        <option value="مهندس ذكاء اصطناعي وتعلم آلة (AI & ML)">مهندس ذكاء اصطناعي وتعلم آلة (AI & ML)</option>
                                        <option value="مطور تطبيقات هواتف (Flutter / React Native)">مطور تطبيقات هواتف (Flutter / React Native)</option>
                                        <option value="مصمم واجهات وتجربة مستخدم (UI/UX)">مصمم واجهات وتجربة مستخدم (UI/UX)</option>
                                        <option value="مهندس جودة واختبارات (QA & Automation)">مهندس جودة واختبارات (QA & Automation)</option>
                                        <option value="مهندس بنية تحتية وأمن سحابي (DevOps & SecOps)">مهندس بنية تحتية وأمن سحابي (DevOps & SecOps)</option>
                                        <option value="مدير منتج وتوثيق فني (Product Manager)">مدير منتج وتوثيق فني (Product Manager)</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition cursor-pointer flex items-center gap-2">
                                <span>إرسال دعوة الانضمام الآن</span>
                                <span>✉️</span>
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-slate-400">فقط قائد ومؤسس الفريق يملك صلاحية إرسال وتوليد دعوات الانضمام.</p>
                    @endif
                </div>
            </div>

            <!-- Invitations History Table -->
            <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <h4 class="text-xs font-black text-slate-900 dark:text-white">سجل الدعوات الصادرة</h4>
                    <span class="text-xs text-slate-400">{{ count($team->invitations) }} دعوة</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-slate-50/75 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 text-xs font-bold border-b border-slate-200 dark:border-slate-800">
                                <th class="p-4">البريد الإلكتروني</th>
                                <th class="p-4">الدور المرشح</th>
                                <th class="p-4">تاريخ الإرسال</th>
                                <th class="p-4">حالة الدعوة</th>
                                <th class="p-4 text-center">رابط الدعوة المباشر</th>
                                @if($isLeader)
                                    <th class="p-4 text-center">إلغاء</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                            @forelse($team->invitations as $invitation)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                                    <td class="p-4 font-bold text-slate-900 dark:text-white font-mono">{{ $invitation->email }}</td>
                                    <td class="p-4 text-slate-600 dark:text-slate-300 font-semibold">{{ $invitation->role_in_team }}</td>
                                    <td class="p-4 text-slate-500 dark:text-slate-400 font-num">{{ $invitation->created_at->format('Y-m-d') }}</td>
                                    <td class="p-4">
                                        @if($invitation->status === 'accepted')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-500">تم القبول ✓</span>
                                        @elseif($invitation->status === 'pending')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-500 animate-pulse">معلقة ⏳</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-500/15 text-slate-400">ملغية ✕</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($invitation->status === 'pending')
                                            <button type="button" @click="copyToClipboard('{{ route('team.invitations.accept', ['token' => $invitation->token]) }}')"
                                                    class="px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 text-[11px] font-bold border border-indigo-200 dark:border-indigo-800 transition cursor-pointer">
                                                نسخ رابط الدعوة 🔗
                                            </button>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    @if($isLeader)
                                        <td class="p-4 text-center">
                                            @if($invitation->status === 'pending')
                                                <form action="{{ route('team.invitations.cancel', ['team' => $team->id, 'invitation' => $invitation->id]) }}" method="POST"
                                                      onsubmit="return confirm('هل تريد إلغاء هذه الدعوة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-1 cursor-pointer" title="إلغاء الدعوة">
                                                        ✕ إلغاء
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isLeader ? 6 : 5 }}" class="p-8 text-center text-slate-400 text-xs">
                                        لم يتم إرسال أي دعوات حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================================================
             TAB 6: MY PROFILE & CV (سيرتي الذاتية وملفي المهني)
             ============================================================ -->
        <div x-show="activeTab === 'my_cv'" class="space-y-6">
            @php
                $myProfile = auth()->user()?->profile ?? ($user?->profile ?? null);
            @endphp
            <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="border-b border-slate-200 dark:border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">ملفي المهني وسيرتي الذاتية (Professional Profile & CV)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">تظهر هذه البيانات لزملائك في الفريق وفي التقرير التنفيذي للمشروع ودليل المنصة العام.</p>
                    </div>

                    @if($myProfile?->cv_url)
                        <a href="{{ $myProfile->cv_url }}" target="_blank"
                           class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800 font-bold text-xs flex items-center gap-2 self-start sm:self-auto hover:bg-emerald-100 transition">
                            <span>تحميل الـ CV الحالي (PDF)</span>
                            <span>📥</span>
                        </a>
                    @endif
                </div>

                <form action="{{ route('team.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المسمى المهني والوظيفي</label>
                            <input type="text" name="job_title" value="{{ old('job_title', $myProfile?->job_title) }}" placeholder="مثال: مهندس برمجيات أول & Full-Stack"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المجال / التخصص الدقيق</label>
                            <input type="text" name="major" value="{{ old('major', $myProfile?->major) }}" placeholder="مثال: هندسة البرمجيات والذكاء الاصطناعي"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رقم الهاتف / واتساب (مع رمز الدولة)</label>
                            <input type="text" name="phone" value="{{ old('phone', $myProfile?->phone) }}" placeholder="+967 77..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">كود الموظف / المعرّف (ID)</label>
                            <input type="text" name="university_id_number" value="{{ old('university_id_number', $myProfile?->university_id_number) }}" placeholder="DEV-..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رفع ملف السيرة الذاتية (CV PDF)</label>
                            <input type="file" name="cv_file" accept=".pdf"
                                   class="w-full text-xs text-slate-500 file:ml-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 dark:file:bg-indigo-950/80 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المهارات التقنية والأدوات (مفصولة بفواصل)</label>
                        <input type="text" name="skills" value="{{ old('skills', $myProfile?->skills) }}" placeholder="مثال: Laravel, Vue.js, Flutter, Docker, Python, Git, Kubernetes"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رابط GitHub</label>
                            <input type="url" name="github_url" value="{{ old('github_url', $myProfile?->github_url) }}" placeholder="https://github.com/..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رابط LinkedIn</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $myProfile?->linkedin_url) }}" placeholder="https://linkedin.com/in/..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رابط معرض الأعمال (Portfolio)</label>
                            <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $myProfile?->portfolio_url) }}" placeholder="https://..."
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">نبذة مهنية وملخص الخبرات</label>
                        <textarea name="bio" rows="4" placeholder="اكتب نبذة موجزة عن خبراتك المهنية والتقنية وإنجازاتك في المشاريع..."
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">{{ old('bio', $myProfile?->bio) }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition cursor-pointer">
                            حفظ وتحديث سيرتي الذاتية 💾
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================================
             TAB 7: PROJECT SETTINGS (خاص بمدير الفريق)
             ============================================================ -->
        @if($isLeader)
            <div x-show="activeTab === 'project'" class="space-y-6">
                <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="border-b border-slate-200 dark:border-slate-800 pb-4">
                        <h3 class="text-base font-black text-slate-900 dark:text-white">إعدادات وتفاصيل المشروع</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">تعديل بيانات المشروع ونسبة الإنجاز ومستودع الكود.</p>
                    </div>

                    <form action="{{ route('team.update', $team->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم الفريق أو Squad *</label>
                                <input type="text" name="name" value="{{ old('name', $team->name) }}" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المجال والتصنيف *</label>
                                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ $team->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان المشروع أو المنتج *</label>
                            <input type="text" name="project_title" value="{{ old('project_title', $team->project_title) }}" required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">المنظمة / الشركة أو المؤسسة التابع لها *</label>
                                <input type="text" name="university" value="{{ old('university', $team->university) }}" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">القسم أو القطاع</label>
                                <input type="text" name="department" value="{{ old('department', $team->department) }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">مرحلة المشروع الحالية</label>
                                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    <option value="ideation" {{ $team->status === 'ideation' ? 'selected' : '' }}>💡 مرحلة التخطيط وتحديد النطاق</option>
                                    <option value="in_progress" {{ $team->status === 'in_progress' ? 'selected' : '' }}>⚡ مرحلة التطوير والبرمجة</option>
                                    <option value="under_review" {{ $team->status === 'under_review' ? 'selected' : '' }}>🔍 مرحلة المراجعة وفحص الجودة</option>
                                    <option value="completed" {{ $team->status === 'completed' ? 'selected' : '' }}>✓ مكتمل وجاهز للإطلاق والتسليم</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">نسبة الإنجاز (0-100%)</label>
                                <input type="number" name="progress_percentage" min="0" max="100" value="{{ old('progress_percentage', $team->progress_percentage) }}" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 font-num">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">مستودع GitHub</label>
                                <input type="url" name="github_repo" value="{{ old('github_repo', $team->github_repo) }}" placeholder="https://github.com/..."
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الوصف العام ونطاق عمل المشروع</label>
                            <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">{{ old('description', $team->description) }}</textarea>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition cursor-pointer">
                                حفظ التعديلات 💾
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    @endif


    <!-- ============================================================
         MODAL 1: INTERACTIVE MEMBER PROFILE & CV DRAWER
         ============================================================ -->
    <div x-show="cvModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-8 bg-black/75 backdrop-blur-md">
            <div @click.outside="cvModal = false" 
                 class="w-full max-w-2xl rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-6 relative overflow-hidden">
                
                <!-- Ambient Glow inside modal -->
                <div class="absolute -left-20 -top-20 w-52 h-52 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Modal Header -->
                <div class="flex items-start justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-3.5">
                        <img :src="selectedMember?.avatar || '{{ asset('images/default-avatar.svg') }}'" 
                             :alt="selectedMember?.name" 
                             class="w-14 h-14 rounded-2xl object-cover ring-2 ring-indigo-500 shadow-md">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-black text-slate-900 dark:text-white" x-text="selectedMember?.name"></h3>
                                <template x-if="selectedMember?.is_leader">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950">👑 مدير الفريق</span>
                                </template>
                            </div>
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold" x-text="selectedMember?.role_in_team"></p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400" x-text="selectedMember?.major"></p>
                        </div>
                    </div>
                    <button @click="cvModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg p-1 cursor-pointer">✕</button>
                </div>

                <!-- Quick Direct Contact Action Buttons (WhatsApp & Mail) -->
                <div class="flex items-center gap-2">
                    <template x-if="selectedMember?.phone && selectedMember?.phone !== 'غير محدد'">
                        <a :href="'https://wa.me/' + selectedMember?.phone.replace(/[^0-9]/g, '')" target="_blank"
                           class="flex-1 py-2 px-3 rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/25 transition text-xs font-bold flex items-center justify-center gap-1.5">
                            <span>مراسلة واتساب فورية 💬</span>
                        </a>
                    </template>
                    <a :href="'mailto:' + selectedMember?.email"
                       class="flex-1 py-2 px-3 rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 hover:bg-indigo-500/25 transition text-xs font-bold flex items-center justify-center gap-1.5">
                        <span>إرسال بريد إلكتروني ✉️</span>
                    </a>
                </div>

                <!-- Academic & Contact Badges -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 text-center">
                        <span class="text-[10px] text-slate-400 font-bold block">المسمى المهني</span>
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block mt-0.5" x-text="selectedMember?.job_title"></span>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 text-center">
                        <span class="text-[10px] text-slate-400 font-bold block">المستوى والخبرة</span>
                        <span class="text-xs font-black text-emerald-500 font-num block mt-0.5" x-text="selectedMember?.gpa"></span>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 text-center">
                        <span class="text-[10px] text-slate-400 font-bold block">كود العضو</span>
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 font-num block mt-0.5" x-text="selectedMember?.university_id"></span>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 text-center">
                        <span class="text-[10px] text-slate-400 font-bold block">الهاتف الشخصي</span>
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block mt-0.5 font-num" x-text="selectedMember?.phone"></span>
                    </div>
                </div>

                <!-- Bio / Summary -->
                <div class="space-y-1.5">
                    <h4 class="text-xs font-black text-slate-900 dark:text-white">النبذة المهنية والشخصية:</h4>
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300 leading-relaxed"
                         x-text="selectedMember?.bio"></div>
                </div>

                <!-- Skills Tags -->
                <div class="space-y-1.5">
                    <h4 class="text-xs font-black text-slate-900 dark:text-white">المهارات التقنية والأدوات:</h4>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="skill in (selectedMember?.skills || [])" :key="skill">
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-indigo-50 dark:bg-indigo-950/70 text-indigo-700 dark:text-indigo-300 border border-indigo-200/70 dark:border-indigo-800/70"
                                  x-text="skill"></span>
                        </template>
                    </div>
                </div>

                <!-- Live Embedded PDF Preview Drawer (If uploaded) -->
                <template x-if="selectedMember?.cv_url">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-800 dark:text-slate-200">معاينة السيرة الذاتية (Live PDF Viewer):</span>
                            <a :href="selectedMember?.cv_url" target="_blank" class="text-indigo-500 hover:underline text-[11px]">فتح في نافذة كاملة ↗</a>
                        </div>
                        <div class="w-full h-56 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <iframe :src="selectedMember?.cv_url" class="w-full h-full" frameborder="0"></iframe>
                        </div>
                    </div>
                </template>

                <!-- Links & Actions -->
                <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <template x-if="selectedMember?.github_url">
                            <a :href="selectedMember?.github_url" target="_blank"
                               class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-800 dark:text-white text-xs font-bold flex items-center gap-1.5 transition">
                                <span>GitHub ↗</span>
                            </a>
                        </template>
                        <template x-if="selectedMember?.linkedin_url">
                            <a :href="selectedMember?.linkedin_url" target="_blank"
                               class="p-2.5 rounded-xl bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 text-blue-600 dark:text-blue-400 text-xs font-bold flex items-center gap-1.5 transition">
                                <span>LinkedIn ↗</span>
                            </a>
                        </template>
                        <template x-if="selectedMember?.portfolio_url">
                            <a :href="selectedMember?.portfolio_url" target="_blank"
                               class="p-2.5 rounded-xl bg-purple-50 dark:bg-purple-950/60 hover:bg-purple-100 text-purple-600 dark:text-purple-400 text-xs font-bold flex items-center gap-1.5 transition">
                                <span>Portfolio ↗</span>
                            </a>
                        </template>
                    </div>

                    <div>
                        <template x-if="selectedMember?.cv_url">
                            <a :href="selectedMember?.cv_url" target="_blank"
                               class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/30 flex items-center gap-2 transition">
                                <span>تحميل السيرة الذاتية (PDF)</span>
                                <span>📥</span>
                            </a>
                        </template>
                        <template x-if="!selectedMember?.cv_url">
                            <span class="text-xs text-slate-400 italic">لم يرفع العضو ملف CV بصيغة PDF بعد</span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================
         MODAL 2: INVITE MEMBER MODAL
         ============================================================ -->
    @if($hasTeam && $isLeader)
        <div x-show="inviteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="inviteModal = false" 
                     class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">✉️</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">إرسال دعوة انضمام لفريقك</h3>
                        </div>
                        <button @click="inviteModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <form action="{{ route('team.invitations.send', $team->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني للعضو *</label>
                            <input type="email" name="email" placeholder="teammate@company.com" required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الدور المقترح في الفريق *</label>
                            <select name="role_in_team" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                <option value="مطور واجهات أمامية (Front-End)">مطور واجهات أمامية (Front-End)</option>
                                <option value="مطور خلفية وسيرفرات (Back-End)">مطور خلفية وسيرفرات (Back-End)</option>
                                <option value="مهندس ذكاء اصطناعي وتعلم آلة (AI & ML)">مهندس ذكاء اصطناعي وتعلم آلة (AI & ML)</option>
                                <option value="مطور تطبيقات هواتف (Flutter / React Native)">مطور تطبيقات هواتف (Flutter / React Native)</option>
                                <option value="مصمم واجهات وتجربة مستخدم (UI/UX)">مصمم واجهات وتجربة مستخدم (UI/UX)</option>
                                <option value="مهندس جودة واختبارات (QA & Automation)">مهندس جودة واختبارات (QA & Automation)</option>
                                <option value="مهندس بنية تحتية وأمن سحابي (DevOps & SecOps)">مهندس بنية تحتية وأمن سحابي (DevOps & SecOps)</option>
                                <option value="مدير منتج وتوثيق فني (Product Manager)">مدير منتج وتوثيق فني (Product Manager)</option>
                            </select>
                        </div>

                        <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-200 dark:border-slate-800">
                            <button type="button" @click="inviteModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition">
                                إرسال الدعوة ✉️
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- ============================================================
         MODAL 3: CREATE TASK MODAL
         ============================================================ -->
    @if($hasTeam)
        <div x-show="taskModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="taskModal = false" 
                     class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">📋</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">إضافة مهمة جديدة لمشروع العمل</h3>
                        </div>
                        <button @click="taskModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <form action="{{ route('team.tasks.store', $team->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان المهمة *</label>
                            <input type="text" name="title" placeholder="مثال: هندسة وبرمجة نقطة اتصال الدفع الإلكتروني..." required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">إسناد للعضو</label>
                                <select name="assigned_to" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    <option value="">بدون إسناد محدد</option>
                                    @foreach($team->members as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->pivot->role_in_team }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الأولوية</label>
                                <select name="priority" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    <option value="medium">متوسطة</option>
                                    <option value="high">عالية 🔺</option>
                                    <option value="urgent">عاجلة جداً ⚡</option>
                                    <option value="low">منخفضة</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">موعد التسليم المتوقع</label>
                                <input type="date" name="due_date"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الحالة المبدئية</label>
                                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                                    <option value="todo">⏳ قيد الانتظار</option>
                                    <option value="in_progress">⚡ قيد التنفيذ</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">وصف تفصيلي للمهمة ومخرجاتها</label>
                            <textarea name="description" rows="3" placeholder="حدد متطلبات المهمة بدقة..."
                                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500"></textarea>
                        </div>

                        <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-200 dark:border-slate-800">
                            <button type="button" @click="taskModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition">
                                حفظ وإسناد المهمة ✓
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- ============================================================
         MODAL 4: UPLOAD DOCUMENT MODAL (VAULT)
         ============================================================ -->
    @if($hasTeam)
        <div x-show="docModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="docModal = false" 
                     class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">📁</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">رفع وثيقة أو مخرج في خزانة المشروع</h3>
                        </div>
                        <button @click="docModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <form action="{{ route('team.documents.store', $team->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم المستند أو المخرج *</label>
                            <input type="text" name="title" placeholder="مثال: وثيقة المعمارية والمواصفات الفنية v2" required
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-teal-500">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">تصنيف الوثيقة *</label>
                                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-teal-500">
                                    <option value="technical">وثائق تقنية ومواصفات (Technical)</option>
                                    <option value="architecture">تصاميم ومعمارية ونماذج (Architecture)</option>
                                    <option value="pitch_deck">عروض تقديمية (Pitch Deck)</option>
                                    <option value="reports">تقارير فحص وجودة (QA & Security)</option>
                                    <option value="agreements">اتفاقيات وسياسات عمل (Agreements)</option>
                                    <option value="general">ملفات عامة أخرى (General)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رقم الإصدار (Version)</label>
                                <input type="text" name="version" value="v1.0" placeholder="v1.0"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-teal-500 font-num">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اختيار الملف المراد رفعه (PDF, DOCX, PPTX, ZIP حتى 30MB) *</label>
                            <input type="file" name="document_file" required
                                   class="w-full text-xs text-slate-500 file:ml-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 dark:file:bg-teal-950/80 file:text-teal-700 dark:file:text-teal-300 hover:file:bg-teal-100 cursor-pointer">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">وصف مختصر لمحتوى الملف</label>
                            <textarea name="description" rows="2" placeholder="اشرح باختصار ما تتضمنه هذه الوثيقة..."
                                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-teal-500"></textarea>
                        </div>

                        <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-200 dark:border-slate-800">
                            <button type="button" @click="docModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md transition">
                                رفع وحفظ في الخزانة 📁
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- ============================================================
         MODAL 5: POST DAILY STANDUP MODAL
         ============================================================ -->
    @if($hasTeam)
        <div x-show="standupModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="standupModal = false" 
                     class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">💬</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">إضافة تحديث يومي للفريق (Daily Standup)</h3>
                        </div>
                        <button @click="standupModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <form action="{{ route('team.standups.store', $team->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">نوع التحديث</label>
                            <select name="type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-purple-500">
                                <option value="update">تحديث تقدم عادي ⚡</option>
                                <option value="milestone">محطة هامة وإنجاز كبير 🏆</option>
                                <option value="blocker">عائق أو مشكلة تقنية ⚠️</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">ما الذي أنجزته اليوم؟ وما هي خطوتك التالية؟ *</label>
                            <textarea name="content" rows="4" placeholder="مثال: أكملت ربط الـ API وعمل فحص الأمان بنجاح..." required
                                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-purple-500"></textarea>
                        </div>

                        <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-200 dark:border-slate-800">
                            <button type="button" @click="standupModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition">
                                نشر التحديث 🚀
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- ============================================================
         MODAL 6: EDIT MEMBER ROLE MODAL (خاص بمدير الفريق)
         ============================================================ -->
    @if($hasTeam && $isLeader)
        <div x-show="roleModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6 bg-black/70 backdrop-blur-sm">
                <div @click.outside="roleModal = false" 
                     class="w-full max-w-md rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-2xl text-right space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">✏️</span>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white">تعديل دور ومسؤولية العضو</h3>
                        </div>
                        <button @click="roleModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">✕</button>
                    </div>

                    <template x-if="memberToEdit">
                        <form :action="'{{ url('/my-team/' . $team->id . '/members') }}/' + memberToEdit.id + '/role'" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم العضو</label>
                                <p class="text-sm font-black text-indigo-600 dark:text-indigo-400" x-text="memberToEdit.name"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الدور والمسؤولية في المشروع *</label>
                                <input type="text" name="role_in_team" :value="memberToEdit.role_in_team" required
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>

                            <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-200 dark:border-slate-800">
                                <button type="button" @click="roleModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500">إلغاء</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition">
                                    حفظ التعديل ✓
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
