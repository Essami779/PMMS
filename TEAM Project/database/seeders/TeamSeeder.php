<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamInvitation;
use App\Models\MemberProfile;
use App\Models\TeamTask;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get or create Leader (Essam)
        $leader = User::firstOrCreate(
            ['email' => 'essam@gmail.com'],
            [
                'name' => 'عصام الشرعبي',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Leader Profile
        MemberProfile::updateOrCreate(
            ['user_id' => $leader->id],
            [
                'job_title' => 'رئيس الفريق & مهندس برمجيات ونظم ذكية',
                'phone' => '+967 770 000 111',
                'university_id_number' => 'UNIV-2024-8841',
                'major' => 'هندسة برمجيات وذكاء اصطناعي',
                'gpa' => 3.92,
                'bio' => 'قائد فريق شغوف بهندسة النظم الموزعة، تطوير تطبيقات السحاب، والذكاء الاصطناعي. أمتلك خبرة متقدمة في قيادة الفرق وتوجيه مسارات التطوير التقني والأكاديمي.',
                'skills' => 'Laravel 12, Flutter, System Design, RESTful APIs, Git & GitHub, Docker, Agile Leadership',
                'github_url' => 'https://github.com',
                'linkedin_url' => 'https://linkedin.com',
                'portfolio_url' => 'https://example.com',
            ]
        );

        // 2. Create Team
        $team = Team::firstOrCreate(
            ['leader_id' => $leader->id],
            [
                'name' => 'فريق الذكاء الاصطناعي (NeuroVision)',
                'project_title' => 'نظام ذكي للتشخيص المبكر لأورام الرئة باستخدام الرؤية الحاسوبية والتعلم العميق',
                'category' => 'الذكاء الاصطناعي وتطبيقات الويب',
                'university' => 'جامعة صنعاء',
                'department' => 'كلية الحاسوب وتكنولوجيا المعلومات - قسم الذكاء الاصطناعي',
                'invite_code' => 'NV-2026',
                'status' => 'in_progress',
                'progress_percentage' => 45,
                'github_repo' => 'https://github.com/example/neurovision-project',
                'description' => 'مشروع تخرج نوعي يهدف إلى بناء منصة متكاملة لتحليل صور الأشعة السينية (X-Ray) والأشعة المقطعية (CT Scan) للكشف التلقائي الدقيق عن الأورام وتقديم تقارير طبية مساعدة للأطباء والاستشاريين.',
            ]
        );

        // Leader Membership
        TeamMember::updateOrCreate(
            ['team_id' => $team->id, 'user_id' => $leader->id],
            [
                'role_in_team' => 'رئيس الفريق ومطور الـ Full-Stack',
                'status' => 'active',
                'joined_at' => now()->subMonths(2),
            ]
        );

        // 3. Create Teammates
        $teammatesData = [
            [
                'name' => 'عاصم العريقي',
                'email' => 'asim@team.test',
                'role' => 'مطور واجهات أمامية وتطبيقات (Front-End & Flutter)',
                'job_title' => 'مطور Flutter & Tailwind CSS',
                'skills' => 'Flutter, Dart, Tailwind CSS, Alpine.js, Responsive UI/UX, State Management',
                'gpa' => 3.85,
                'bio' => 'متخصص في بناء واجهات المستخدم التفاعلية وتطبيقات الهاتف الذكي مع مراعاة أعلى معايير الـ UX والتجاوب السلس مع مختلف الأجهزة.',
            ],
            [
                'name' => 'سارة المنصوري',
                'email' => 'sara@team.test',
                'role' => 'مهندسة ذكاء اصطناعي ونماذج تعلم عميق (AI & DL Engineer)',
                'job_title' => 'باحثة ذكاء اصطناعي وتنقيب بيانات',
                'skills' => 'Python, PyTorch, TensorFlow, Computer Vision, OpenCV, NumPy, Fast-API',
                'gpa' => 3.96,
                'bio' => 'شغوفة بتدريب شبكات CNN ونماذج الرؤية الحاسوبية وتحسين دقة التصنيف في الصور الطبية ومعالجة البيانات الضخمة.',
            ],
            [
                'name' => 'خالد الحميري',
                'email' => 'khaled@team.test',
                'role' => 'مهندس جودة واختبارات وأمن برمجيات (QA & SecOps)',
                'job_title' => 'مهندس اختبارات وضمان جودة QA',
                'skills' => 'PHPUnit, Playwright E2E, Postman API Testing, OWASP Top 10, Security Audits',
                'gpa' => 3.78,
                'bio' => 'مسؤول عن تأكيد استقرار المنظومة، كتابة الاختبارات الوظيفية والعقدية، وفحص الثغرات الأمنية لضمان تسليم مشروع جامعي خالٍ من المشاكل.',
            ],
        ];

        foreach ($teammatesData as $tData) {
            $user = User::firstOrCreate(
                ['email' => $tData['email']],
                [
                    'name' => $tData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            MemberProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'job_title' => $tData['job_title'],
                    'skills' => $tData['skills'],
                    'gpa' => $tData['gpa'],
                    'bio' => $tData['bio'],
                    'major' => 'تقنية معلومات وحاسوب',
                    'university_id_number' => 'UNIV-' . rand(1000, 9999),
                    'phone' => '+967 77' . rand(1000000, 9999999),
                    'github_url' => 'https://github.com',
                    'linkedin_url' => 'https://linkedin.com',
                ]
            );

            TeamMember::updateOrCreate(
                ['team_id' => $team->id, 'user_id' => $user->id],
                [
                    'role_in_team' => $tData['role'],
                    'status' => 'active',
                    'joined_at' => now()->subDays(rand(10, 45)),
                ]
            );
        }

        // 4. Create Sample Invitations
        TeamInvitation::updateOrCreate(
            ['team_id' => $team->id, 'email' => 'designer.creative@gmail.com'],
            [
                'invited_by' => $leader->id,
                'role_in_team' => 'مصمم هوية بصرية وتجربة مستخدم (UI/UX Designer)',
                'token' => 'sample_token_invitation_creative_designer_998',
                'status' => 'pending',
                'expires_at' => now()->addDays(5),
            ]
        );

        TeamInvitation::updateOrCreate(
            ['team_id' => $team->id, 'email' => 'data.analyst@gmail.com'],
            [
                'invited_by' => $leader->id,
                'role_in_team' => 'محلل بيانات طبية وبيولوجية',
                'token' => 'sample_token_invitation_data_analyst_772',
                'status' => 'pending',
                'expires_at' => now()->addDays(6),
            ]
        );

        // 5. Create Sample Tasks for Monitoring
        $asim = User::where('email', 'asim@team.test')->first();
        $sara = User::where('email', 'sara@team.test')->first();
        $khaled = User::where('email', 'khaled@team.test')->first();

        $sampleTasks = [
            [
                'title' => 'تصميم وبناء شاشات عرض نتائج التحليل بالأشعة السينية',
                'description' => 'تنفيذ شاشات عرض نموذج الـ DICOM وعرض الـ Heatmap باستخدام Flutter مع التجاوب التام.',
                'assigned_to' => $asim?->id,
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => now()->addDays(4),
            ],
            [
                'title' => 'تدريب شبكة ResNet50 على مجموعة بيانات LIDC-IDRI للرئة',
                'description' => 'تنظيف الصور وعمل Data Augmentation ثم تدريب الموديل للوصول لدقة تفوق 94%.',
                'assigned_to' => $sara?->id,
                'status' => 'in_progress',
                'priority' => 'urgent',
                'due_date' => now()->addDays(2),
            ],
            [
                'title' => 'إعداد وثيقة المتطلبات البرمجية الرسمية (SRS Document)',
                'description' => 'إكمال الفصل الثالث من متطلبات التخرج وتوثيق Use Case Diagrams و Sequence Diagrams.',
                'assigned_to' => $leader->id,
                'status' => 'done',
                'priority' => 'medium',
                'due_date' => now()->subDays(3),
            ],
            [
                'title' => 'إجراء اختبارات الأمان وفحص الثغرات لنقاط اتصال الـ API',
                'description' => 'فحص صلاحيات الوصول (IDOR) والتحقق من تشفير بيانات المرضى الطبية في قاعدة البيانات.',
                'assigned_to' => $khaled?->id,
                'status' => 'todo',
                'priority' => 'high',
                'due_date' => now()->addDays(7),
            ],
            [
                'title' => 'ربط واجهة التطبيق مع السيرفر المحلي عبر REST API',
                'description' => 'تجهيز قنوات الاتصال وتلقي التنبيهات اللحظية عند انتهاء معالجة الصور.',
                'assigned_to' => $asim?->id,
                'status' => 'review',
                'priority' => 'medium',
                'due_date' => now()->addDays(1),
            ],
        ];

        foreach ($sampleTasks as $st) {
            TeamTask::updateOrCreate(
                ['team_id' => $team->id, 'title' => $st['title']],
                $st
            );
        }

        // 6. Create Sample Standups
        $standups = [
            [
                'user_id' => $leader->id,
                'content' => 'تم بحمد الله اعتماد وثيقة المتطلبات (SRS) بعد مراجعة المشرف الأكاديمي، ونبدأ الآن مرحلة ربط الموديل بالواجهات.',
                'type' => 'milestone',
                'created_at' => now()->subHours(8),
            ],
            [
                'user_id' => $sara?->id ?? $leader->id,
                'content' => 'انتهيت من تدريب 30 Epochs على شبكة ResNet ووصلت دقة الفحص إلى 94.6%. جاري تجهيز الـ Confusion Matrix.',
                'type' => 'update',
                'created_at' => now()->subHours(4),
            ],
            [
                'user_id' => $asim?->id ?? $leader->id,
                'content' => 'أكملت شاشات استعراض نتائج الفحوصات في Flutter ورفعت التحديثات على فرع feature/dicom-viewer على GitHub.',
                'type' => 'update',
                'created_at' => now()->subHours(2),
            ],
        ];

        foreach ($standups as $sd) {
            \App\Models\TeamStandup::create([
                'team_id' => $team->id,
                'user_id' => $sd['user_id'],
                'content' => $sd['content'],
                'type' => $sd['type'],
                'created_at' => $sd['created_at'],
            ]);
        }
    }
}

