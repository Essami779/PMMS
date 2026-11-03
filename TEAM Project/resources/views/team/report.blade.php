<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>التقرير التنفيذي لتقدم المشروع - {{ $team->name }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Readex+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .font-num {
            font-family: 'Readex Pro', sans-serif;
        }
        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                font-size: 11pt;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
            }
            .report-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
<body class="py-8 px-4 sm:px-8">

    <!-- Top Action Bar (Hide in Print) -->
    <div class="no-print max-w-5xl mx-auto mb-6 flex items-center justify-between gap-4 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
        <a href="{{ route('team.workspace') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 flex items-center gap-1.5 transition">
            <span>← العودة إلى مساحة إدارة الفريق</span>
        </a>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-500 font-bold hidden sm:inline">نسخة جاهزة للطباعة والتصدير كـ PDF للإدارة والعملاء</span>
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 flex items-center gap-2 cursor-pointer transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>طباعة التقرير التنفيذي / حفظ PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Report Document Container -->
    <div class="report-card max-w-5xl mx-auto bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-xl space-y-8">
        
        <!-- Document Header / Organization Letterhead -->
        <div class="flex items-start justify-between border-b-2 border-slate-900 pb-6">
            <div class="space-y-1">
                <h2 class="text-base font-black text-slate-900">{{ $team->university }}</h2>
                <h3 class="text-xs font-bold text-slate-600">{{ $team->department ?? 'قطاع هندسة وتطوير النظم والمنتجات' }}</h3>
                <p class="text-[11px] text-slate-500">إدارة المشاريع والتطوير المؤسسي (PMO)</p>
            </div>
            
            <div class="text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-2xl shadow-md">
                    💼
                </div>
                <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase block mt-1">Executive Report</span>
            </div>

            <div class="text-left space-y-1">
                <div class="text-xs font-bold text-slate-800">التاريخ: <span class="font-num">{{ now()->format('Y-m-d') }}</span></div>
                <div class="text-xs text-slate-500">حالة التقرير: معتمد رسمي</div>
                <div class="text-[10px] text-indigo-600 font-bold font-mono">CODE: {{ $team->invite_code }}</div>
            </div>
        </div>

        <!-- Document Title -->
        <div class="text-center space-y-2 py-2">
            <span class="px-4 py-1 rounded-full text-xs font-black bg-indigo-50 text-indigo-700 border border-indigo-200 inline-block">
                تقرير المتابعة والإنجاز الدوري للمشروع (Executive Progress Report)
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                مشروع: {{ $team->project_title }}
            </h1>
            <p class="text-sm font-bold text-slate-600">
                فريق التطوير: <span class="text-indigo-600 font-black">{{ $team->name }}</span> | قطاع العمل: <span>{{ $team->category }}</span>
            </p>
        </div>

        <!-- Section 1: Progress & Status Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
            <div>
                <span class="text-xs text-slate-500 font-bold block">نسبة الإنجاز الكلية:</span>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-2xl font-black text-indigo-600 font-num">{{ $team->progress_percentage }}%</span>
                    <div class="flex-1 h-3 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $team->progress_percentage }}%"></div>
                    </div>
                </div>
            </div>
            <div>
                <span class="text-xs text-slate-500 font-bold block">مرحلة المشروع الحالية:</span>
                <span class="text-sm font-black text-slate-800 mt-1 inline-block">
                    @if($team->status === 'completed') مكتمل وجاهز للنشر والتسليم ✓
                    @elseif($team->status === 'in_progress') مرحلة التطوير والبرمجة ⚡
                    @elseif($team->status === 'under_review') مرحلة المراجعة وفحص الجودة 🔍
                    @else مرحلة التخطيط وتحديد النطاق
                    @endif
                </span>
            </div>
            <div>
                <span class="text-xs text-slate-500 font-bold block">مدير وممثل الفريق:</span>
                <span class="text-sm font-black text-slate-800 mt-1 inline-block">{{ $team->leader->name }}</span>
            </div>
        </div>

        <!-- Section 2: Team Members Table -->
        <div class="space-y-3">
            <h3 class="text-sm font-black text-slate-900 border-r-4 border-indigo-600 pr-2">
                أولاً: فريق العمل وتوزيع الأدوار والمسؤوليات
            </h3>
            <table class="w-full text-right border-collapse border border-slate-200 text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <th class="p-3 border-l border-slate-200">#</th>
                        <th class="p-3 border-l border-slate-200">اسم العضو / المطور</th>
                        <th class="p-3 border-l border-slate-200">كود العضو (ID)</th>
                        <th class="p-3 border-l border-slate-200">الدور والمسؤولية في المشروع</th>
                        <th class="p-3 border-l border-slate-200">المسمى المهني</th>
                        <th class="p-3">بيانات التواصل</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($team->members as $index => $m)
                        <tr class="{{ $team->isLeader($m) ? 'bg-indigo-50/40 font-semibold' : '' }}">
                            <td class="p-3 border-l border-slate-200 font-num">{{ $index + 1 }}</td>
                            <td class="p-3 border-l border-slate-200 font-bold text-slate-900">
                                {{ $m->name }}
                                @if($team->isLeader($m))
                                    <span class="text-[10px] text-amber-600 mr-1 font-bold">(مدير الفريق)</span>
                                @endif
                            </td>
                            <td class="p-3 border-l border-slate-200 font-num text-slate-600">{{ $m->profile?->university_id_number ?? 'MEM-' . ($index + 1) . '092' }}</td>
                            <td class="p-3 border-l border-slate-200 text-indigo-700 font-bold">{{ $m->pivot->role_in_team }}</td>
                            <td class="p-3 border-l border-slate-200 text-slate-600">{{ $m->profile?->job_title ?? 'مهندس برمجيات' }}</td>
                            <td class="p-3 font-num text-slate-600">{{ $m->profile?->phone ?? $m->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section 3: Tasks Breakdown -->
        <div class="space-y-3">
            <h3 class="text-sm font-black text-slate-900 border-r-4 border-indigo-600 pr-2">
                ثانياً: جدول المهام ومؤشرات إنجاز خطة العمل
            </h3>
            <table class="w-full text-right border-collapse border border-slate-200 text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <th class="p-3 border-l border-slate-200">المهمة وموضوع العمل</th>
                        <th class="p-3 border-l border-slate-200">المسؤول عن التنفيذ</th>
                        <th class="p-3 border-l border-slate-200">الأولوية</th>
                        <th class="p-3 border-l border-slate-200">الموعد المستهدف</th>
                        <th class="p-3">حالة الإنجاز</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($team->tasks as $task)
                        <tr>
                            <td class="p-3 border-l border-slate-200">
                                <span class="font-bold text-slate-900">{{ $task->title }}</span>
                                @if($task->description)
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $task->description }}</p>
                                @endif
                            </td>
                            <td class="p-3 border-l border-slate-200 font-bold text-slate-700">{{ $task->assignee?->name ?? 'غير محدد' }}</td>
                            <td class="p-3 border-l border-slate-200">
                                @if($task->priority === 'urgent') عاجل جداً
                                @elseif($task->priority === 'high') أولوية عالية
                                @else عادية
                                @endif
                            </td>
                            <td class="p-3 border-l border-slate-200 font-num text-slate-600">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'مفتوح' }}</td>
                            <td class="p-3">
                                @if($task->status === 'done')
                                    <span class="text-emerald-700 font-bold">✓ مكتملة بنجاح</span>
                                @elseif($task->status === 'in_progress')
                                    <span class="text-amber-700 font-bold">⚡ قيد التنفيذ</span>
                                @elseif($task->status === 'review')
                                    <span class="text-purple-700 font-bold">🔍 قيد المراجعة</span>
                                @else
                                    <span class="text-slate-500">⏳ قيد الانتظار</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-slate-400">لا توجد مهام مسجلة بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Section 4: Project Deliverables & Documents (Vault) -->
        @if(count($team->documents) > 0)
            <div class="space-y-3">
                <h3 class="text-sm font-black text-slate-900 border-r-4 border-indigo-600 pr-2">
                    ثالثاً: وثائق ومخرجات المشروع المعتمدة في الخزانة
                </h3>
                <table class="w-full text-right border-collapse border border-slate-200 text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                            <th class="p-3 border-l border-slate-200">اسم المستند / الوثيقة</th>
                            <th class="p-3 border-l border-slate-200">التصنيف</th>
                            <th class="p-3 border-l border-slate-200">الإصدار</th>
                            <th class="p-3 border-l border-slate-200">الحجم</th>
                            <th class="p-3">تاريخ الاعتماد والرفع</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($team->documents as $doc)
                            <tr>
                                <td class="p-3 border-l border-slate-200 font-bold text-slate-900">{{ $doc->title }}</td>
                                <td class="p-3 border-l border-slate-200 text-slate-600">{{ $doc->category }}</td>
                                <td class="p-3 border-l border-slate-200 font-num font-bold text-indigo-700">{{ $doc->version }}</td>
                                <td class="p-3 border-l border-slate-200 font-num text-slate-500">{{ $doc->formatted_size }}</td>
                                <td class="p-3 font-num text-slate-600">{{ $doc->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Document Signatures Footer -->
        <div class="pt-8 border-t-2 border-slate-300 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-8">
                <p class="font-bold text-slate-700">توقيع مدير / رئيس الفريق:</p>
                <div class="h-10 border-b border-dashed border-slate-400 w-48 mx-auto"></div>
                <p class="font-bold text-slate-900">{{ $team->leader->name }}</p>
            </div>
            
            <div class="space-y-8">
                <p class="font-bold text-slate-700">اعتماد الإدارة / العميل / المشرف المسؤول:</p>
                <div class="h-10 border-b border-dashed border-slate-400 w-48 mx-auto"></div>
                <p class="font-bold text-slate-400">الاسم / التوقيع والختم المعتمد</p>
            </div>
        </div>

        <div class="text-center pt-4 text-[10px] text-slate-400 border-t border-slate-100">
            تم استخراج هذا التقرير آلياً عبر منصة TEAM Hub لإدارة ومتابعة الفرق والمشاريع - {{ date('Y') }}
        </div>
    </div>

</body>
</html>
