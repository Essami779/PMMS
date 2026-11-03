<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إنشاء حساب وتحديد المسار - {{ config('app.name', 'منصة TEAM Hub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Readex+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-page: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-focus-border: #6366f1;
            --dark-panel-bg: #0f172a;
            --dark-panel-border: #1e293b;
        }

        .dark {
            --bg-page: #070b14;
            --card-bg: #0f172a;
            --card-border: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: #070b14;
            --input-border: #1e293b;
            --input-focus-border: #818cf8;
            --dark-panel-bg: #070b14;
            --dark-panel-border: #1e293b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', 'Readex Pro', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            transition: background-color 0.3s ease;
        }

        /* Ambient Glow Blobs (Dashboard Sync) */
        .ambient-blob-1 {
            position: fixed;
            top: -140px;
            right: -140px;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.18) 0%, rgba(99, 102, 241, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }
        .ambient-blob-2 {
            position: fixed;
            bottom: -140px;
            left: -140px;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.14) 0%, rgba(168, 85, 247, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .register-card-wrapper {
            width: 100%;
            max-width: 1100px;
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 30px 70px -15px rgba(15, 23, 42, 0.15), 0 0 1px 1px rgba(99, 102, 241, 0.05);
            display: flex;
            flex-direction: row;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        @media (max-width: 950px) {
            .register-card-wrapper {
                flex-direction: column-reverse;
                max-width: 560px;
                border-radius: 24px;
            }
        }

        .dark-side-panel {
            width: 42%;
            background: linear-gradient(155deg, #0f172a 0%, #1e1b4b 60%, #090d16 100%) !important;
            border-right: 1px solid var(--dark-panel-border);
            padding: 42px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff !important;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 950px) {
            .dark-side-panel {
                width: 100%;
                border-right: none;
                border-top: 1px solid var(--dark-panel-border);
                padding: 28px 20px;
            }
        }

        .form-side-panel {
            width: 58%;
            padding: 40px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 950px) {
            .form-side-panel {
                width: 100%;
                padding: 28px 20px;
            }
        }

        /* 3D Persona Card Button */
        .persona-card {
            border: 2px solid var(--input-border);
            border-radius: 20px;
            padding: 16px 12px;
            background-color: var(--card-bg);
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            text-align: center;
        }
        .persona-card:hover {
            transform: translateY(-3px);
            border-color: #6366f1;
        }
        .persona-card.active-team {
            border-color: #4f46e5 !important;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(79, 70, 229, 0.02) 100%);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.25);
        }
        .persona-card.active-company {
            border-color: #f59e0b !important;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0.02) 100%);
            box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.25);
        }
        .persona-card.active-consultant {
            border-color: #10b981 !important;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.02) 100%);
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.25);
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            height: 46px;
            background-color: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 14px;
            padding: 0 16px;
            font-size: 13.5px;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--input-focus-border);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .dark .form-input:focus {
            background-color: #0f172a;
        }

        /* Live Preview Card in Dark Side */
        .live-preview-box {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 22px;
            margin-top: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
    </style>
</head>

<body x-data="{ 
        isDark: localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : false,
        track: new URLSearchParams(window.location.search).get('track') || 'team',
        name: 'قائد الفريق الابتكاري',
        entityName: 'فريق NeuroVision الذكي',
        specialty: 'الذكاء الاصطناعي وتعلم الآلة',
        password: '',
        get passwordStrength() {
            let score = 0;
            if (this.password.length >= 8) score++;
            if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) score++;
            if (/\d/.test(this.password)) score++;
            if (/[^A-Za-z0-9]/.test(this.password)) score++;
            return score;
        },
        setTrack(t) { 
            this.track = t;
            if (t === 'team') {
                this.name = 'قائد الفريق الابتكاري';
                this.entityName = 'فريق NeuroVision الذكي';
                this.specialty = 'الذكاء الاصطناعي وتعلم الآلة';
            } else if (t === 'company') {
                this.name = 'مسؤول علاقات الشركاء';
                this.entityName = 'مجموعة يمن تك السحابية';
                this.specialty = 'الاتصالات وتقنية المعلومات';
            } else {
                this.name = 'د. عبد الله اليافعي';
                this.entityName = 'استشاري معمارية النظم';
                this.specialty = 'الأنظمة الموزعة والأمن السيبراني';
            }
        }
      }"
      x-init="$watch('isDark', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          if (val) {
              document.documentElement.classList.add('dark');
          } else {
              document.documentElement.classList.remove('dark');
          }
      });
      if (isDark) { document.documentElement.classList.add('dark'); }"
      :class="isDark ? 'dark' : ''">

    <!-- Ambient Glowing Background Blobs -->
    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <!-- Main Container Card -->
    <div class="register-card-wrapper">

        <!-- ========================================================
             RIGHT COLUMN: Registration Inputs Form
             ======================================================== -->
        <div class="form-side-panel">
            <div>
                <!-- Top Navigation & Return Link -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200 dark:border-slate-800">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>العودة إلى الصفحة الرئيسية</span>
                    </a>

                    <button type="button" @click="isDark = !isDark" class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <span x-text="isDark ? '☀️ نهاري' : '🌙 ليلي'"></span>
                    </button>
                </div>

                <!-- Form Heading -->
                <div class="mb-6">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">إنشاء حساب وتحديد المسار</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">اختر هويتك في المنظومة لتفعيل الأدوات واللوحات المناسبة لك</p>
                </div>

                <!-- 1. 3D Persona Cards Selector -->
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <!-- Option 1: Team -->
                    <div @click="setTrack('team')" :class="track === 'team' ? 'active-team' : ''" class="persona-card">
                        <span class="text-3xl block mb-1">🎓</span>
                        <span class="font-black text-xs block text-slate-900 dark:text-white">فريق ومشروع</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">للطلاب والخريجين</span>
                        <div x-show="track === 'team'" class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[11px] font-black shadow-md">✓</div>
                    </div>

                    <!-- Option 2: Company -->
                    <div @click="setTrack('company')" :class="track === 'company' ? 'active-company' : ''" class="persona-card">
                        <span class="text-3xl block mb-1">🏢</span>
                        <span class="font-black text-xs block text-slate-900 dark:text-white">شركة راعية</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">لقطاع الأعمال</span>
                        <div x-show="track === 'company'" class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-[11px] font-black shadow-md">✓</div>
                    </div>

                    <!-- Option 3: Consultant -->
                    <div @click="setTrack('consultant')" :class="track === 'consultant' ? 'active-consultant' : ''" class="persona-card">
                        <span class="text-3xl block mb-1">👨‍🏫</span>
                        <span class="font-black text-xs block text-slate-900 dark:text-white">شخصية استشارية</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">للخبراء والمحكمين</span>
                        <div x-show="track === 'consultant'" class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[11px] font-black shadow-md">✓</div>
                    </div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    
                    <input type="hidden" name="account_type" :value="track">

                    <div class="space-y-4">
                        
                        <!-- Full Name Input -->
                        <div>
                            <label class="form-label">
                                <span x-show="track === 'team'">اسم قائد أو ممثل الفريق *</span>
                                <span x-show="track === 'company'">اسم ممثل الشركة الرسمي *</span>
                                <span x-show="track === 'consultant'">اسم المستشار أو الأستاذ الأكاديمي *</span>
                            </label>
                            <input type="text" name="name" x-model="name" value="{{ old('name') }}" required autofocus class="form-input" placeholder="الاسم الكامل">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                        </div>

                        <!-- Professional Email -->
                        <div>
                            <label class="form-label">البريد الإلكتروني المهني أو الجامعي *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="user@university.edu أو name@company.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                        </div>

                        <!-- DYNAMIC FIELDS: TEAM TRACK -->
                        <div x-show="track === 'team'" x-transition class="p-4 rounded-2xl bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/60 space-y-3.5">
                            <div>
                                <label class="form-label text-indigo-950 dark:text-indigo-200">اسم الفريق أو عنوان المشروع المقترح</label>
                                <input type="text" name="team_or_project_name" x-model="entityName" class="form-input bg-white dark:bg-slate-900" placeholder="مثال: فريق NeuroVision للذكاء الاصطناعي">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label text-indigo-950 dark:text-indigo-200">تخصص ومجال المشروع</label>
                                    <select name="project_category" x-model="specialty" class="form-input bg-white dark:bg-slate-900 text-xs">
                                        <option value="الذكاء الاصطناعي وتعلم الآلة">الذكاء الاصطناعي وتعلم الآلة</option>
                                        <option value="تطبيقات الويب والموبايل">تطبيقات الويب والموبايل</option>
                                        <option value="إنترنت الأشياء والنظم المدمجة">إنترنت الأشياء والنظم المدمجة</option>
                                        <option value="الأمن السيبراني والشبكات">الأمن السيبراني والشبكات</option>
                                        <option value="حلول التقنية المالية FinTech">حلول التقنية المالية FinTech</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label text-indigo-950 dark:text-indigo-200">الجامعة أو الكلية</label>
                                    <input type="text" name="university_name" class="form-input bg-white dark:bg-slate-900" placeholder="مثال: جامعة صنعاء">
                                </div>
                            </div>
                        </div>

                        <!-- DYNAMIC FIELDS: COMPANY TRACK -->
                        <div x-show="track === 'company'" x-cloak x-transition class="p-4 rounded-2xl bg-amber-50/70 dark:bg-amber-950/40 border border-amber-100 dark:border-amber-900/60 space-y-3.5">
                            <div>
                                <label class="form-label text-amber-950 dark:text-amber-200">اسم الشركة أو المؤسسة الرسمية</label>
                                <input type="text" name="company_name" x-model="entityName" class="form-input bg-white dark:bg-slate-900" placeholder="مثال: مجموعة يمن تك السحابية">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label text-amber-950 dark:text-amber-200">قطاع الأعمال</label>
                                    <select name="company_sector" x-model="specialty" class="form-input bg-white dark:bg-slate-900 text-xs">
                                        <option value="الاتصالات وتقنية المعلومات">الاتصالات وتقنية المعلومات</option>
                                        <option value="البنوك والخدمات المصرفية">البنوك والخدمات المصرفية</option>
                                        <option value="الطاقة والصناعة">الطاقة والصناعة</option>
                                        <option value="حاضنات ومسرعات الأعمال">حاضنات ومسرعات الأعمال</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label text-amber-950 dark:text-amber-200">نوع الشراكة والرعاية</label>
                                    <select name="sponsorship_type" class="form-input bg-white dark:bg-slate-900 text-xs">
                                        <option value="رعاية وتمويل مشاريع">رعاية وتمويل مشاريع</option>
                                        <option value="تدريب وتوظيف كفاءات">تدريب وتوظيف كفاءات</option>
                                        <option value="طرح تحديات أعمال">طرح تحديات أعمال لحلها</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- DYNAMIC FIELDS: CONSULTANT TRACK -->
                        <div x-show="track === 'consultant'" x-cloak x-transition class="p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/60 space-y-3.5">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label text-emerald-950 dark:text-emerald-200">اللقب الأكاديمي أو المهني</label>
                                    <select name="consultant_title" class="form-input bg-white dark:bg-slate-900 text-xs">
                                        <option value="أستاذ مشارك / دكتور">أستاذ مشارك / دكتور</option>
                                        <option value="أستاذ مساعد">أستاذ مساعد</option>
                                        <option value="كبير مهندسي برمجيات">كبير مهندسي برمجيات</option>
                                        <option value="استشاري ريادة أعمال">استشاري ريادة أعمال</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label text-emerald-950 dark:text-emerald-200">سنوات الخبرة</label>
                                    <input type="number" name="experience_years" min="1" max="50" class="form-input bg-white dark:bg-slate-900" placeholder="مثال: 12">
                                </div>
                            </div>
                            <div>
                                <label class="form-label text-emerald-950 dark:text-emerald-200">مجال التخصص الاستشاري الدقيق</label>
                                <input type="text" name="consulting_specialty" x-model="specialty" class="form-input bg-white dark:bg-slate-900" placeholder="مثال: هندسة النظم الموزعة والأمن السيبراني">
                            </div>
                        </div>

                        <!-- Password Inputs & Interactive Strength Meter -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">كلمة المرور *</label>
                                <input type="password" name="password" x-model="password" required autocomplete="new-password" class="form-input" placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                            </div>
                            <div>
                                <label class="form-label">تأكيد كلمة المرور *</label>
                                <input type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                            </div>
                        </div>

                        <!-- Password Strength Visual Meter -->
                        <div x-show="password.length > 0" x-cloak class="pt-1">
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                                <span>مستوى أمان كلمة المرور:</span>
                                <span :class="{
                                    'text-rose-500': passwordStrength <= 1,
                                    'text-amber-500': passwordStrength === 2,
                                    'text-blue-500': passwordStrength === 3,
                                    'text-emerald-500': passwordStrength === 4
                                }" x-text="passwordStrength <= 1 ? 'ضعيف' : (passwordStrength === 2 ? 'متوسط' : (passwordStrength === 3 ? 'جيد جداً' : 'فائق الأمان ✓'))"></span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden flex gap-1">
                                <div class="h-full rounded-full transition-all duration-300 flex-1" :class="passwordStrength >= 1 ? (passwordStrength === 1 ? 'bg-rose-500' : (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500')) : 'bg-transparent'"></div>
                                <div class="h-full rounded-full transition-all duration-300 flex-1" :class="passwordStrength >= 2 ? (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500') : 'bg-transparent'"></div>
                                <div class="h-full rounded-full transition-all duration-300 flex-1" :class="passwordStrength >= 3 ? (passwordStrength === 3 ? 'bg-blue-500' : 'bg-emerald-500') : 'bg-transparent'"></div>
                                <div class="h-full rounded-full transition-all duration-300 flex-1" :class="passwordStrength >= 4 ? 'bg-emerald-500' : 'bg-transparent'"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full h-13 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-sm shadow-xl shadow-indigo-600/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 font-readex cursor-pointer">
                                <span>إتمام إنشاء الحساب والانضمام للمنظومة</span>
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-200 dark:border-slate-800 text-center">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    لديك حساب مسجل بالفعل؟
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline mr-1">
                        تسجيل الدخول من هنا
                    </a>
                </p>
            </div>
        </div>

        <!-- ========================================================
             LEFT COLUMN: Live Interactive Identity Card Preview
             ======================================================== -->
        <div class="dark-side-panel">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-slate-200 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>معاينة حية لبطاقة هويتك في المنظومة</span>
                </div>

                <h1 class="text-2xl font-black text-white leading-tight mb-2">
                    انضمام مخصص بحسب هويتك
                </h1>
                <p class="text-xs text-slate-400 leading-relaxed mb-6">
                    بمجرد تسجيل حسابك، تصبح بطاقتك نشطة في الدليل الوطني للمشاريع والخبراء.
                </p>

                <!-- THE REAL-TIME LIVE PREVIEW CARD -->
                <div class="live-preview-box">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full" 
                              :class="{
                                  'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30': track === 'team',
                                  'bg-amber-500/20 text-amber-300 border border-amber-500/30': track === 'company',
                                  'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30': track === 'consultant'
                              }"
                              x-text="track === 'team' ? '🎓 بطاقة فريق جامعي' : (track === 'company' ? '🏢 بطاقة شركة وشريك راعٍ' : '👨‍🏫 بطاقة مستشار معتمد')">
                        </span>
                        <span class="text-[11px] text-emerald-400 font-black">● عضوية معتمدة</span>
                    </div>

                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-2xl text-white shadow-lg"
                             :class="{
                                 'bg-gradient-to-tr from-indigo-600 to-indigo-400': track === 'team',
                                 'bg-gradient-to-tr from-amber-600 to-amber-400 text-slate-950': track === 'company',
                                 'bg-gradient-to-tr from-emerald-600 to-emerald-400': track === 'consultant'
                             }"
                             x-text="name ? name.charAt(0) : 'T'">
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white" x-text="name || 'اسم المستخدم'"></h3>
                            <div class="text-xs text-slate-300 font-bold" x-text="entityName || 'اسم الفريق أو المنشأة'"></div>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-black/30 border border-white/10 text-xs">
                        <div class="text-[10px] text-slate-400 mb-0.5">التخصص والمجال المحدد:</div>
                        <div class="font-bold text-amber-300 text-[11px]" x-text="specialty || 'المجال المحدد'"></div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-400">
                        <span>الرقم المرجعي: #TM-{{ rand(1000, 9999) }}</span>
                        <span class="text-emerald-400 font-bold">جاهز للتفعيل ✓</span>
                    </div>
                </div>

            </div>

            <div class="pt-6 border-t border-white/10 text-[11px] text-slate-400 flex items-center justify-between">
                <span>منصة TEAM Hub &copy; {{ date('Y') }}</span>
                <span class="text-amber-400 font-bold">تشفير وأمان 100%</span>
            </div>
        </div>

    </div>

</body>
</html>
