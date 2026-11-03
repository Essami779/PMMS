<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FrontendController extends Controller
{
    /**
     * الصفحة التعريفية الرئيسية للمنصة (Landing Page)
     */
    public function index()
    {
        $stats = [
            'teams_count' => 128,
            'projects_count' => 94,
            'companies_count' => 46,
            'consultants_count' => 82,
            'consulting_hours' => 1450,
            'sponsorship_volume' => '1.2M+',
        ];

        return view('welcome', compact('stats'));
    }

    /**
     * صفحة استعراض وإنشاء الفرق الطلابية ومشاريع التخرج
     */
    public function teams(Request $request)
    {
        $categories = [
            'الكل',
            'الذكاء الاصطناعي وتعلم الآلة',
            'تطبيقات الويب والموبايل',
            'إنترنت الأشياء والنظم المدمجة',
            'الأمن السيبراني والشبكات',
            'التقنيات الطبية والصحية',
            'حلول الأعمال والمالية',
        ];

        $sampleTeams = [
            [
                'id' => 1,
                'name' => 'فريق الذكاء التشخيصي (NeuroVision)',
                'project_title' => 'نظام ذكي للتشخيص المبكر لأورام الرئة باستخدام الرؤية الحاسوبية',
                'category' => 'الذكاء الاصطناعي وتعلم الآلة',
                'leader' => 'عصام العريقي',
                'university' => 'مختبر الابتكار والذكاء الاصطناعي',
                'members_count' => 4,
                'members_needed' => 1,
                'status' => 'مرحلة النمذجة الأولية',
                'color' => 'indigo',
                'icon' => 'brain',
                'tags' => ['Python', 'TensorFlow', 'FastAPI', 'Flutter'],
                'sponsorship_status' => 'مفتوح للرعاية',
            ],
            [
                'id' => 2,
                'name' => 'فريق الحصاد الذكي (AgriTech Hub)',
                'project_title' => 'شبكة استشعار ذكية لإدارة الري والتربة بالطاقة الشمسية',
                'category' => 'إنترنت الأشياء والنظم المدمجة',
                'leader' => 'سارة المنصوري',
                'university' => 'حاضنة التقنيات الزراعية والبيئية',
                'members_count' => 5,
                'members_needed' => 0,
                'status' => 'جاهز للاختبار الميداني',
                'color' => 'emerald',
                'icon' => 'cpu',
                'tags' => ['IoT', 'ESP32', 'LoRaWAN', 'Laravel'],
                'sponsorship_status' => 'تحت رعاية شركة تقنية',
            ],
            [
                'id' => 3,
                'name' => 'فريق الدرع السيبراني (CyberVault)',
                'project_title' => 'منصة متقدمة للكشف عن الثغرات الأمنية في تطبيقات السحابة',
                'category' => 'الأمن السيبراني والشبكات',
                'leader' => 'خالد الحميري',
                'university' => 'مركز أبحاث الأمن السيبراني السحابي',
                'members_count' => 3,
                'members_needed' => 2,
                'status' => 'مرحلة التطوير المتقدم',
                'color' => 'blue',
                'icon' => 'shield',
                'tags' => ['Security', 'Docker', 'Go', 'React'],
                'sponsorship_status' => 'يبحث عن مستشار أمني',
            ],
            [
                'id' => 4,
                'name' => 'فريق الرعاية عن بعد (TeleHealth Pro)',
                'project_title' => 'منصة متكاملة للاستشارات الطبية عن بعد وتتبع المؤشرات الحيوية',
                'category' => 'التقنيات الطبية والصحية',
                'leader' => 'ريما القدسي',
                'university' => 'مركز تقنيات الصحة الرقمية المتقدمة',
                'members_count' => 4,
                'members_needed' => 0,
                'status' => 'جاهز للعرض النهائي',
                'color' => 'rose',
                'icon' => 'heart-pulse',
                'tags' => ['HealthTech', 'WebRTC', 'Tailwind', 'PostgreSQL'],
                'sponsorship_status' => 'مفتوح للاستثمار',
            ],
            [
                'id' => 5,
                'name' => 'فريق السداد الذكي (PayPoint)',
                'project_title' => 'بوابة دفع إلكتروني تدعم المحافظ الرقمية المحلية ونقاط البيع السريعة',
                'category' => 'حلول الأعمال والمالية',
                'leader' => 'محمد باعباد',
                'university' => 'مسرعة أعمال وحلول الفنتك',
                'members_count' => 3,
                'members_needed' => 1,
                'status' => 'مرحلة التكامل المالي',
                'color' => 'amber',
                'icon' => 'wallet',
                'tags' => ['FinTech', 'Laravel 12', 'Vue.js', 'QR Code'],
                'sponsorship_status' => 'مفتوح للرعاية والشراكة',
            ],
            [
                'id' => 6,
                'name' => 'فريق اللوجستيات الخضراء (GreenRoute)',
                'project_title' => 'خوارزمية ذكية لتحسين مسارات النقل والشحن وتقليل الانبعاثات الكربونية',
                'category' => 'الذكاء الاصطناعي وتعلم الآلة',
                'leader' => 'أحمد العنسي',
                'university' => 'مختبر سلاسل الإمداد والنظم الخضراء',
                'members_count' => 4,
                'members_needed' => 0,
                'status' => 'مرحلة براءة الاختراع',
                'color' => 'teal',
                'icon' => 'truck',
                'tags' => ['AI', 'GIS', 'Routing', 'Node.js'],
                'sponsorship_status' => 'ممول جزئياً',
            ],
        ];

        return view('teams.index', compact('categories', 'sampleTeams'));
    }

    /**
     * صفحة استعراض الشركات والمؤسسات الشريكة والفرص المتاحة
     */
    public function companies(Request $request)
    {
        $sectors = [
            'الكل',
            'الاتصالات وتقنية المعلومات',
            'البنوك والخدمات المالية',
            'الطاقة والصناعة',
            'الصحة والأدوية',
            'التجارة والخدمات اللوجستية',
            'الحاضنات ومسرعات الأعمال',
        ];

        $sampleCompanies = [
            [
                'id' => 1,
                'name' => 'مجموعة يمن تك للحلول السحابية (YemenTech Cloud)',
                'sector' => 'الاتصالات وتقنية المعلومات',
                'city' => 'صنعاء',
                'established' => '2016',
                'logo_bg' => 'from-blue-600 to-indigo-700',
                'sponsorship_tracks' => ['رعاية مشاريع الذكاء الاصطناعي', 'تدريب منتهي بالتوظيف', 'سيرفرات سحابية مجانية'],
                'open_opportunities' => 4,
                'supported_teams_count' => 12,
                'about' => 'شركة رائدة في تقديم البنية التحتية السحابية وحلول التحول الرقمي للشركات والمؤسسات الأكاديمية.',
            ],
            [
                'id' => 2,
                'name' => 'بنك الأمل للتمويل والابتكار الرقمي',
                'sector' => 'البنوك والخدمات المالية',
                'city' => 'عدن',
                'established' => '2010',
                'logo_bg' => 'from-emerald-600 to-teal-700',
                'sponsorship_tracks' => ['تمويل أفكار FinTech', 'جوائز هاكاثون الابتكار', 'حاضنة أعمال مصرفية'],
                'open_opportunities' => 3,
                'supported_teams_count' => 18,
                'about' => 'مؤسسة مصرفية تدعم الشمول المالي والمشاريع الريادية الشابة وحلول الدفع الرقمي الآمنة.',
            ],
            [
                'id' => 3,
                'name' => 'شركة الطاقة المتجددة المتقدمة (EcoPower)',
                'sector' => 'الطاقة والصناعة',
                'city' => 'تعز',
                'established' => '2019',
                'logo_bg' => 'from-amber-500 to-orange-600',
                'sponsorship_tracks' => ['تمويل نماذج الطاقة الشمسية', 'معدات وأجهزة معملية', 'تبني براءات اختراع'],
                'open_opportunities' => 2,
                'supported_teams_count' => 7,
                'about' => 'مختصة في تقديم أنظمة الطاقة الشمسية والحلول الهندسية المستدامة لقطاعات الزراعة والصناعة.',
            ],
            [
                'id' => 4,
                'name' => 'مسرعة الرواد للأعمال الناشئة (Ruwwad Accelerator)',
                'sector' => 'الحاضنات ومسرعات الأعمال',
                'city' => 'حضرموت',
                'established' => '2021',
                'logo_bg' => 'from-purple-600 to-fuchsia-700',
                'sponsorship_tracks' => ['احتضان 6 أشهر', 'توجيه واستشارات قانونية ومالية', 'ربط بالمستثمرين الملائكيين'],
                'open_opportunities' => 5,
                'supported_teams_count' => 24,
                'about' => 'بيئة أعمال متكاملة تساعد الفرق الجامعية والريادية على تحويل مشاريع التخرج إلى شركات ناشئة مربحة.',
            ],
        ];

        return view('companies.index', compact('sectors', 'sampleCompanies'));
    }

    /**
     * صفحة دليل المستشارين والخبراء الأكاديميين والمهنيين
     */
    public function consultants(Request $request)
    {
        $specialties = [
            'الكل',
            'الذكاء الاصطناعي وتحليل البيانات',
            'الأمن السيبراني والبنية التحتية',
            'هندسة البرمجيات والأنظمة الموزعة',
            'دراسات الجدوى ونماذج الأعمال',
            'إنترنت الأشياء وهندسة الأجهزة',
            'الملكية الفكرية وبراءات الاختراع',
        ];

        $sampleConsultants = [
            [
                'id' => 1,
                'name' => 'د. عصام عبد الرحمن الشرجبي',
                'title' => 'أستاذ مشارك في علوم البيانات والذكاء الاصطناعي',
                'specialty' => 'الذكاء الاصطناعي وتحليل البيانات',
                'experience_years' => 16,
                'rating' => 4.9,
                'reviews_count' => 64,
                'consultation_hours' => 380,
                'university' => 'جامعة صنعاء',
                'avatar_color' => 'indigo',
                'bio' => 'خبير استشاري ومحكم معتمد في المؤتمرات الدولية، ساهم في الإشراف على أكثر من 45 مشروع تخرج وبحث علمي متقدم.',
                'skills' => ['Machine Learning', 'Computer Vision', 'PyTorch', 'Data Science'],
                'availability' => 'متاح لجلسات إرشادية (عن بعد وحضوري)',
            ],
            [
                'id' => 2,
                'name' => 'م. نادية محمد القباطي',
                'title' => 'كبير معماريي البرمجيات والأنظمة السحابية',
                'specialty' => 'هندسة البرمجيات والأنظمة الموزعة',
                'experience_years' => 12,
                'rating' => 4.8,
                'reviews_count' => 52,
                'consultation_hours' => 290,
                'university' => 'استشارية قطاع خاص',
                'avatar_color' => 'blue',
                'bio' => 'مهندسة برمجيات أولى متخصصة في تصميم النظم الموزعة عالية الأداء والمعمارية النظيفة (DDD & Microservices).',
                'skills' => ['System Design', 'Cloud Architecture', 'DevOps', 'Laravel / Go'],
                'availability' => 'متاح مساءً عبر مكالمات الفيديو',
            ],
            [
                'id' => 3,
                'name' => 'د. فهد عبد الولي الأكوع',
                'title' => 'استشاري أمن المعلومات والتحقيق الجنائي الرقمي',
                'specialty' => 'الأمن السيبراني والبنية التحتية',
                'experience_years' => 14,
                'rating' => 5.0,
                'reviews_count' => 48,
                'consultation_hours' => 310,
                'university' => 'جامعة العلوم والتكنولوجيا',
                'avatar_color' => 'emerald',
                'bio' => 'مدرب ومحاضر دولي في اختبار الاختراق الأخلاقي وحماية تطبيقات الويب والشبكات المؤسسية.',
                'skills' => ['Penetration Testing', 'Security Audits', 'OWASP', 'Forensics'],
                'availability' => 'متاح لجلسات مراجعة الأمان للمشاريع',
            ],
            [
                'id' => 4,
                'name' => 'أ. هيثم ناصر الصهيبي',
                'title' => 'مستشار تطوير الأعمال ونماذج الاستثمار الريادي',
                'specialty' => 'دراسات الجدوى ونماذج الأعمال',
                'experience_years' => 10,
                'rating' => 4.9,
                'reviews_count' => 70,
                'consultation_hours' => 420,
                'university' => 'مؤسسة الرواد لدعم ريادة الأعمال',
                'avatar_color' => 'amber',
                'bio' => 'مرشد أعمال ساعد عشرات الفرق الجامعية على تحويل أفكار مشاريعهم إلى خطط عمل قابلة للتمويل وجذب المستثمرين.',
                'skills' => ['Business Model Canvas', 'Pitch Decks', 'Financial Valuation', 'Go-To-Market'],
                'availability' => 'متاح لورش العمل والمراجعات الفردية',
            ],
        ];

        return view('consultants.index', compact('specialties', 'sampleConsultants'));
    }
}
