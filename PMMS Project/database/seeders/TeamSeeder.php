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
                'university_id_number' => 'DEV-LEAD-8841',
                'major' => 'هندسة البرمجيات والذكاء الاصطناعي (Senior Software Engineer)',
                'gpa' => 3.92,
                'bio' => 'قائد ومطور برمجيات أول شغوف بهندسة النظم الموزعة، تطوير التطبيقات السحابية، وقيادة فرق العمل الرشيقة (Agile Scrum). خبرة عميقة في إدارة دورة حياة المنتجات من التخطيط حتى الإطلاق.',
                'skills' => 'Laravel 12, Flutter, System Design, RESTful APIs, Git & GitHub, Docker, Agile Leadership',
                'github_url' => 'https://github.com',
                'linkedin_url' => 'https://linkedin.com',
                'portfolio_url' => 'https://example.com',
            ]
        );

        // 2. Create Team
        $team = Team::updateOrCreate(
            ['leader_id' => $leader->id],
            [
                'name' => 'فريق تطوير النظم والذكاء الاصطناعي (NeuroVision Squad)',
                'project_title' => 'منظومة التشخيص المبكر الذكية للرعاية الصحية والتحليل الطبي المتقدم',
                'category' => 'الذكاء الاصطناعي وتطبيقات الويب',
                'university' => 'مختبرات الابتكار الرقمي والتقنيات الحديثة',
                'department' => 'قطاع هندسة وتطوير الحلول البرمجية المؤسسية',
                'invite_code' => 'NV-2026',
                'status' => 'in_progress',
                'progress_percentage' => 45,
                'github_repo' => 'https://github.com/example/neurovision-project',
                'description' => 'مشروع تقني استراتيجي يهدف إلى بناء منصة متكاملة للتحليل الطبي الدقيق لصور الأشعة السينية والمقطعية باستخدام خوارزميات الرؤية الحاسوبية المتقدمة لخدمة المستشفيات والمراكز التخصصية.',
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

        // 7. Seed Sample Project Deliverables & Documents (Vault)
        $sampleDocs = [
            [
                'title' => 'وثيقة المتطلبات البرمجية والمواصفات الفنية (SRS & Architecture)',
                'description' => 'المخطط الشامل لمعمارية النظام، واجهات برمجة التطبيقات، ونطاق عمل المشروع.',
                'category' => 'technical',
                'file_name' => 'SRS_System_Architecture_v2.pdf',
                'file_path' => 'documents/sample_srs.pdf',
                'file_size' => 4823449, // ~4.6 MB
                'file_type' => 'pdf',
                'version' => 'v2.1',
            ],
            [
                'title' => 'مخططات وتصاميم تجربة المستخدم والمعمارية (UI/UX & UML Diagrams)',
                'description' => 'مخططات Use Case, Class Diagrams, وتصاميم واجهات التطبيق.',
                'category' => 'architecture',
                'file_name' => 'UI_UX_Design_Prototypes.pdf',
                'file_path' => 'documents/sample_design.pdf',
                'file_size' => 8421000, // ~8.4 MB
                'file_type' => 'pdf',
                'version' => 'v1.4',
            ],
            [
                'title' => 'عرض المشروع للمستثمرين وأصحاب المصلحة (Pitch Deck)',
                'description' => 'العرض التقديمي التعريفي بالقيمة السوقية، حلول النظام، وخطط التوسع التجاري.',
                'category' => 'pitch_deck',
                'file_name' => 'Executive_Project_Pitch_Deck.pptx',
                'file_path' => 'documents/sample_pitch.pptx',
                'file_size' => 12582912, // ~12 MB
                'file_type' => 'pptx',
                'version' => 'v1.0',
            ],
            [
                'title' => 'تقرير فحص الأمان واختبارات الجودة (Security Audit & QA Report)',
                'description' => 'تقرير فحوصات الـ Penetration Testing والـ Unit Contracts وضمان استقرار النظام.',
                'category' => 'reports',
                'file_name' => 'Security_QA_Audit_Summary.pdf',
                'file_path' => 'documents/sample_qa.pdf',
                'file_size' => 2154300, // ~2.1 MB
                'file_type' => 'pdf',
                'version' => 'v1.0',
            ],
        ];

        foreach ($sampleDocs as $sDoc) {
            \App\Models\TeamDocument::updateOrCreate(
                ['team_id' => $team->id, 'title' => $sDoc['title']],
                array_merge($sDoc, [
                    'uploaded_by' => $leader->id,
                ])
            );
        }

        // 8. Seed Sample Consultations & Mentorship Sessions
        $sampleConsultations = [
            [
                'consultant_name' => 'د. نبيل عبد الحكيم الشرعبي',
                'consultant_title' => 'استشاري أول نظم الذكاء الاصطناعي والحوسبة السحابية',
                'consultant_avatar' => 'NS',
                'topic' => 'مراجعة خوارزميات الاستدلال (Inference) وتسريع معالجة الصور الطبية',
                'category' => 'technical',
                'description' => 'مناقشة تحسين أداء نماذج الـ Deep Learning في استخراج الميزات من صور الأشعة المقطعية وضمان دقة تتجاوز 96%.',
                'status' => 'completed',
                'session_date' => now()->subDays(4)->setTime(16, 0),
                'meeting_link' => 'https://meet.google.com/nabil-ai-session',
                'recommendations' => "1. الاعتماد على تقنية TensorRT لتحويل أوزان النموذج وتحسين كفاءة استهلاك معالج الرسوميات GPU.\n2. فصل خدمة الـ Inference عن الواجهة الخلفية عبر Microservice مستقلة ذات Auto-scaling.\n3. تطبيق Data Augmentation موسع لتحسين تعميم النموذج على الحالات النادرة.",
                'rating' => 5,
            ],
            [
                'consultant_name' => 'م. لمياء أنور السقاف',
                'consultant_title' => 'خبيرة الأمن السيبراني واختبار الاختراق والامتثال السحابي',
                'consultant_avatar' => 'LS',
                'topic' => 'فحص أمان واجهات RESTful وحماية وتشفير السجلات الطبية للمرضى',
                'category' => 'security',
                'description' => 'مراجعة آليات المصادقة باستخدام JWT، اختبار الثغرات الشائعة (OWASP Top 10)، والتأكد من مطابقة معايير تشفير البيانات في وضع السكون ونقل البيانات.',
                'status' => 'confirmed',
                'session_date' => now()->addDays(2)->setTime(18, 30),
                'meeting_link' => 'https://meet.google.com/sec-cyber-audit',
                'recommendations' => null,
                'rating' => null,
            ],
            [
                'consultant_name' => 'د. حسام طارق المقطري',
                'consultant_title' => 'مستشار نمذجة الأعمال وجولات الاستثمار وعروض المستثمرين',
                'consultant_avatar' => 'HM',
                'topic' => 'مراجعة نموذج القيمة التجارية وخطة تسعير خدمات التحليل للمستشفيات',
                'category' => 'business',
                'description' => 'دراسة السوق المستهدف لقطاع الرعاية الصحية، إعداد التوقعات المالية للسنة الأولى، وهيكلة عرض القيمة للمستثمرين.',
                'status' => 'pending',
                'session_date' => null,
                'meeting_link' => null,
                'recommendations' => null,
                'rating' => null,
            ],
        ];

        foreach ($sampleConsultations as $sCon) {
            \App\Models\TeamConsultation::updateOrCreate(
                ['team_id' => $team->id, 'topic' => $sCon['topic']],
                array_merge($sCon, [
                    'requested_by' => $leader->id,
                ])
            );
        }

        // 9. Seed Sample War Room Discussions & Replies
        $d1 = \App\Models\TeamDiscussion::updateOrCreate(
            ['team_id' => $team->id, 'title' => '📌 تدشين مرحلة الربط والدمج المتكامل (Milestone 2 Integration Sprint)'],
            [
                'user_id' => $leader->id,
                'content' => "أعضاء الفريق الرائعين، نفتتح رسمياً هذا الأسبوع سباق الربط والتكامل الشامل بين واجهة الـ Flutter ونظام الباك إند مع خادم الذكاء الاصطناعي.\nيرجى من الجميع الالتزام بمعايير الـ Clean Architecture وتوثيق أي نقاط تواصل جديدة في خزانة الوثائق والـ Pull Requests.",
                'category' => 'announcement',
                'is_pinned' => true,
                'replies_count' => 2,
            ]
        );

        \App\Models\TeamDiscussionReply::firstOrCreate(
            ['discussion_id' => $d1->id, 'user_id' => 8], // Asim
            ['content' => 'مستعدون تماماً، تم تجهيز كافة الـ Bloc Events وتجهيز بيئة الاختبارات على أجهزة الآيفون والأندرويد.']
        );
        \App\Models\TeamDiscussionReply::firstOrCreate(
            ['discussion_id' => $d1->id, 'user_id' => 9], // Sara
            ['content' => 'واجهات الـ REST API في الـ Backend جاهزة ومحمية بـ JWT Middleware، ونقاط التوثيق منشورة في Swagger.']
        );

        $d2 = \App\Models\TeamDiscussion::updateOrCreate(
            ['team_id' => $team->id, 'title' => '🚨 تحسين زمن استجابة خادم الـ Inference وضغط حجم الصور'],
            [
                'user_id' => 10, // Khaled
                'content' => "لاحظت أثناء اختبار الـ Load Testing أن إرسال صور أشعة عالية الدقة بصيغة DICOM غير مضغوطة يرفع استهلاك الذاكرة في السيرفر إلى 85%. ما هو الحل المقترح؟",
                'category' => 'blocker',
                'is_pinned' => false,
                'replies_count' => 1,
            ]
        );

        \App\Models\TeamDiscussionReply::firstOrCreate(
            ['discussion_id' => $d2->id, 'user_id' => $leader->id],
            ['content' => 'اقتراح ممتاز؛ سنعتمد تحويل الصور في جهة العميل (Client-side Preprocessing) وضغطها وفق معايير WebP بدون فقدان الجودة الطبية قبل إرسالها للباك إند، وقد تم توثيق ذلك في توصيات الدكتور نبيل.']
        );

        $d3 = \App\Models\TeamDiscussion::updateOrCreate(
            ['team_id' => $team->id, 'title' => '📐 معايير توثيق الكود والالتزام بنمط Karpathy Guidelines'],
            [
                'user_id' => 9, // Sara
                'content' => "أرجو من جميع الزملاء مراجعة كود الـ PRs والتأكد من البساطة المباشرة (Simplicity First) وتجنب أي تعقيد غير ضروري قبل الرفع لفرع main.",
                'category' => 'architecture',
                'is_pinned' => false,
                'replies_count' => 0,
            ]
        );
    }
}

