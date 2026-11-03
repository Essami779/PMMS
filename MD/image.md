# الهيكل الأساسي والمفصل لمشروع التخرج: نظام إدارة ومتابعة المشاريع

**التطبيق الميداني والهيكلي الشامل لنظام إدارة ومتابعة المشاريع (Project Management & Tracking System)**

---

## جدول المحتويات والصفحات التمهيدية (Table of Contents)

* **I. الإهداء (Dedication)**: إلى كل من أنار درب العلم والعمل، إلى أسرنا الكريمة وأساتذتنا الأفاضل.
* **II. التفويض (Authorization)**: نموذج تفويض الجامعة بنشر وتداول البحث لأغراض أكاديمية.
* **III. شكر وتقدير (Acknowledgment)**: كلمة شكر للجامعة، الكلية، الدكتور المشرف، والشركات الناشئة المشاركة بالدراسة.
* **IV. لجنة المناقشة (Examiner Committee)**: أسماء أعضاء لجنة الحكم والمناقشة والتواقيع.
* **V. الملخص (Abstract)**:
  * **باللغة العربية**: ملخص شامل يتناول فكرة المنصة (ويب Laravel وموبايل Flutter)، معمارية العمل بدون اتصال (Offline-First)، دمج الذكاء الاصطناعي المحلي (Ollama)، البوابات الخمس، وتقاسم الأرباح المحاسبي.
  * **باللغة الإنجليزية**: Full abstract summarizing the platform's vision, Laravel & Flutter stack, Offline-First synchronization, Local AI implementation, multi-portal design, and profit-sharing capabilities.
* **VI. فهرس المحتويات (Table of Contents)**
* **VII. قائمة الأشكال (List of Figures)**: مخططات DFD, ERD, UML, واجهات المستخدم وشاشات المزامنة.
* **VIII. قائمة الجداول (List of Tables)**: جداول قاعدة البيانات، دراسة الجدوى، والتحليل المقارن.
* **IX. قائمة الاختصارات (List of Abbreviations)**: (MIS, AI, ERD, DFD, UML, CI/CD, CPU, RAM, GPU, REST API).

---

## الفصل الأول: الإطار العام للمشروع (Introduction & General Charter)

### 1. مقدمة (Introduction)
مقدمة مفصلة حول تحول بيئات العمل نحو الفرق البرمجية الناشئة والتحديات التشغيلية (انقطاع الشبكة، سرية الأكواد، تكلفة الأدوات السحابية).

### 2. تعريف المشروع (Definition of the project)
منصة إدارية متكاملة للشركات البرمجية الصغيرة والناشئة والفرق المستقلة، تتكون من موقع ويب (Laravel) وتطبيق موبايل (Flutter) يعملان بأسلوب (Offline-First) مع دمج الذكاء الاصطناعي المحلي (Ollama).

### 3. تحديد المشكلة (Problem Statement)
توقف إنتاجية الفرق عند انقطاع الإنترنت، مخاطر تسريب أسرار الأكواد عبر الذكاء الاصطناعي السحابي، عدم الشفافية مع العملاء، غياب تتبع العهد ومواصفات أجهزة المطورين، والنزاعات في توزيع الأرباح.

### 4. أهداف المشروع (Project Objectives)
* بناء منصة تعمل دون اتصال بشبكة الإنترنت مع مزامنة تلقائية.
* فحص جودة الكود والأمان وتوطين النصوص محلياً عبر الذكاء الاصطناعي (Ollama).
* توفير 5 بوابات مخصصة (العميل، الموظفون، الخبراء، التوظيف، الإدارة الكلية).
* أتمتة حساب وتقاسم الأرباح والتنبؤ بالمخاطر المالية والعقود الإلكترونية.
* تتبع مواصفات الأجهزة والعهد والتحفيز غير المالي ومحلل الإرهاق.

### 5. أهمية المشروع (Project Importance)
تمكين الشركات الناشئة من رفع الإنتاجية، خفض الاشتراكات، حماية الملكية الفكرية، وتحقيق العدالة المالية والشفافية.

### 6. نطاق وحدود المشروع (Project Scope and Limitations)
* **النطاق الوظيفي**: إدارة المهام، المزامنة، الذكاء الاصطناعي المحلي، 5 بوابات، التوظيف، التقارير الصوتية، وتقاسم الأرباح.
* **الحدود التقنية والمكانية**: بيئة العمل على خوادم محلية وسحابية، موجه للشركات البرمجية الناشئة في اليمن والإقليم.

### 7. الأدوات والتقنيات المستخدمة (Tools used in the project)
* **Backend**: Laravel Framework (PHP 8.x), MySQL Database.
* **Frontend & Mobile**: Flutter (Dart) لضمان العمل الموحد على الويب والموبايل.
* **Local AI**: Ollama Engine (Llama 3 / Mistral) للفحص والتأمين المحلي.
* **DevOps & Integration**: GitHub API, Docker, CI/CD Pipeline.
* **IDE & Tools**: VS Code, Git, Postman, Figma.

### 8. المنهجية المستخدمة لعمل المشروع (Research & Development Methodology)
اعتماد منهجية التطوير السريع **(Agile / Scrum)** بالإضافة إلى منهج بحوث تطوير النظم **(Design Science Research Methodology)**.

### 9. الجدول الزمني للمشروع (Timetable for the project)
جدول مفصل مقسم على 16 أسبوعاً (تحليل المتطلبات، التصميم، البرمجة، دمج الذكاء الاصطناعي، اختبار Offline-First، والتسليم).

### 10. مخطط جانت للمشروع (Gantt Chart for the project)

#### الشكل (1-1): مخطط جانت الزمني للمشروع (Gantt Chart)
```mermaid
gantt
    title الشكل (1-1): مخطط جانت الزمني التفصيلي لمراحل تنفيذ مشروع نظام إدارة ومتابعة المشاريع
    dateFormat  YYYY-MM-DD
    axisFormat  %Y-%m-%d
    
    section المرحلة الأولى: الجمع والتحليل
    جمع المتطلبات وتحليل البوابات الخمس    :active, a1, 2026-08-01, 14d
    إعداد وثيقة متطلبات النظام SRS        :a1_sub, 2026-08-08, 7d
    
    section المرحلة الثانية: التصميم المعماري
    تصميم DFD, ERD, UML وقواعد البيانات   :a2, 2026-08-15, 21d
    
    section المرحلة الثالثة: التطوير والبرمجة
    تطوير Laravel REST APIs               :a3, 2026-09-05, 28d
    تطوير تطبيقات Flutter (ويب وموبايل)   :a4, 2026-09-20, 28d
    دمج Offline-Sync & Ollama Local AI    :a5, 2026-10-15, 21d
    
    section المرحلة الرابعة: الاختبار والتوثيق
    الاختبارات التشغيلية وفحص الأمان       :a6, 2026-11-05, 14d
    تسليم التقرير النهائي والمناقشة الأكاديمية :a7, 2026-11-19, 14d
```

### 11. تنظيم التقرير (Report Organization)
عرض موجز لمحتويات الفصول الخمسة للمشروع.

---

## الفصل الثاني: الإطار النظري والدراسات السابقة (Literature Review)

### 1. خلفية الدراسة (Background)
استعراض التطور التاريخي لأدوات إدارة المشاريع والتحول نحو معمارية (Offline-First) والذكاء الاصطناعي المحلي.

### 2. الدراسات السابقة والمنصات المنافسة (Literature Review)
* **Productive.io**: إدارة الوكالات والربحية (سحابي كلياً).
* **Teamwork.com**: إدارة المهام والمشاريع (يفتقر للأوفلاين والعهد).
* **Wrike.com**: إدارة الأعمال المؤسسية (معقد ومكلف).
* **Monday.com**: التخصيص وإدارة بيئات العمل (لا يدعم فحص الكود المحلي دون إنترنت).
* **الفجوة البحثية**: تقديم منصة تجمع بين الأوفلاين والذكاء الاصطناعي المحلي وتقاسم الأرباح وتتبع العهد الصلبة.

### 3. النظام الحالي وتحدياته (Existing system)
تحليل الاعتماد على جداول Excel وتطبيقات الدردشة العادية والمنصات المشتتة.

### 4. دراسة الجدوى (Feasibility Study)
* **أ. الجدوى التقنية (Technical Feasibility)**: توفر تقنيات Laravel وFlutter وOllama مجاناً كتقنيات مفتوحة المصدر.
* **ب. الجدوى الاقتصادية (Economic Feasibility)**: توفير تكاليف الاشتراكات الشهرية السحابية وزيادة الأرباح الناتجة عن عدم توقف الإنتاجية.
* **ج. الجدوى التشغيلية (Operational Feasibility)**: سهولة واجهات المستخدم للموظفين والعملاء وسلاسة المزامنة.

### 5. إدارة المخاطر (Risks management)
* **أ. تحديد المخاطر (Determination of risk)**: تعارض البيانات أثناء المزامنة، بطء الذكاء الاصطناعي المحلي على الأجهزة الضعيفة، مخاطر التأخير المالي.
* **ب. التحكم بالمخاطر (Risk control)**: آليات حل تعارض البيانات (CRDTs / Timestamp resolution)، اختيار نماذج AI خفيفة (Ollama 3B/7B)، والإنذار المبكر للتكاليف.

---

## الفصل الثالث: تحليل النظام (System Analysis)

### 1. طرق جمع المتطلبات (Methods of collecting requirements)
المقابلات مع المطورين والمدراء، الاستبيانات، وتحليل الوثائق ومستودعات GitHub.

### 2. متطلبات العمل (Work requirements)
دورة عمل إدارة المشاريع، تسجيل الحضور، رفع الكود، فحص الأمان، وإصدار الفواتير وتقاسم الأرباح.

### 3. متطلبات النظام (System Requirements)
متطلبات السيرفرات والأجهزة العتادية ومحرك الذكاء الاصطناعي.

### 4. المتطلبات الوظيفية (Functional requirements)
* **بوابة العميل**: عرض نسبة الإنجاز، الفواتير، جدول المراحل، النشرات الأسبوعية الآلية.
* **بوابة الموظفين والمشرفين**: التحضير الذكي، تتبع النشاط والجهد، السير الذاتية وGitHub، إدارة مواصفات الأجهزة والعهد (CPU/RAM/GPU)، نظام النجوم، ومحلل الإرهاق.
* **بوابة الخبراء والمستشارين**: تقديم الاستشارات وتنظيم الجلسات.
* **بوابة التوظيف**: استعراض البروفايلات والتعاقد مع الأفراد والفرق.
* **لوحة التحكم الإدارة**: المتابعة الميزانيات، المهل الزمنية، السيرفرات، وإدارة الإعلانات.
* **الذكاء الاصطناعي والـ DevOps**: فحص جودة الكود محلياً، توطين النصوص، المزامنة فور عودة الشبكة، التقارير الصوتية.

### 5. المتطلبات غير الوظيفية (Non-functional requirements)
* **الأداء والتوافقية**: زمن استجابة سريع ومزامنة خلفية سلسة.
* **الأمان والخصوصية**: تشفير البيانات المحلية وسرية أسرار الكود المصدري.
* **الموثوقية وقابلية التوسع**: العمل المستمر (Offline-First) ودعم التوسع المستقبلي.

### 6. متطلبات المستخدم (User requirements)
سهولة التنقل، الدعم اللغوي المزدوج، والوضوح المحاسبي.

### 7. تحليل المدخلات (Input analysis)
بيانات المهام، ساعات الحضور، بيانات الأجهزة، كود GitHub، النشرات، والفواتير.

### 8. تحليل المخرجات (Output analysis)
تقارير نسبة الإنجاز، الفواتير، توزيع الأرباح، تقارير جودة الكود والأمان، وتحليلات الإرهاق.

### 9. مخطط تدفق البيانات (DFD)

#### الشكل (3-1): المخطط البيئي الأكاديمي للنظام (Context Diagram - Level 0)
```mermaid
graph TD
    classDef entity fill:#f8fafc,stroke:#1e293b,stroke-width:1.5px,color:#0f172a;
    classDef process fill:#eff6ff,stroke:#2563eb,stroke-width:2px,color:#1e3a8a;
    classDef extSys fill:#faf5ff,stroke:#7e22ce,stroke-width:1.5px,color:#581c87;

    subgraph ContextDiagram ["المخطط البيئي الأكاديمي للنظام (Context Diagram - Level 0)"]
        
        Process0(("0.0 <br> نظام إدارة ومتابعة المشاريع والفرق <br> (Project Management System)")):::process
        
        Entity1["العميل <br> (Client Entity)"]:::entity
        Entity2["الموظف / المشرف <br> (Employee / Supervisor)"]:::entity
        Entity3["الخبير / المستشار <br> (Expert / Consultant)"]:::entity
        Entity4["جهة التوظيف <br> (Recruiter Entity)"]:::entity
        Entity5["مستودع GitHub الخارجي <br> (External GitHub Service)"]:::extSys

        %% Client Flows
        Entity1 -->|"بيانات التسجيل، طلبات المشاريع، دفع الفواتير"| Process0
        Process0 -->|"نسبة الإنجاز، الفواتير الإلكترونية، التقارير"| Entity1

        %% Employee Flows
        Entity2 -->|"التحضير الذكي، تحديث المهام، الكود المصدري، مواصفات الجهاز"| Process0
        Process0 -->|"جدول المهام، نتائج فحص Ollama، مؤشر الإرهاق، الرصيد"| Entity2

        %% Expert Flows
        Entity3 -->|"تقديم استشارة فنية، تحديد المواعيد المتاحة"| Process0
        Process0 -->|"طلبات الاستشارة، جداول الجلسات، التقييمات"| Entity3

        %% Recruiter Flows
        Entity4 -->|"طلب التعاقد، البحث عن الكفاءات، شروط العقد"| Process0
        Process0 -->|"بروفايلات المطورين، معرض الأعمال، تقارير GitHub"| Entity4

        %% GitHub External System Flows
        Process0 -->|"Push Code / REST API Requests"| Entity5
        Entity5 -->|"Webhooks Notifications, Commits, Pull Requests"| Process0
    end
```

#### الشكل (3-2): المخطط الصفري الأكاديمي للنظام (Level-0 DFD Diagram)
```mermaid
graph TD
    classDef entity fill:#f8fafc,stroke:#334155,stroke-width:1.5px,color:#0f172a;
    classDef process fill:#eff6ff,stroke:#2563eb,stroke-width:2px,color:#1e3a8a;
    classDef store fill:#f0fdf4,stroke:#16a34a,stroke-width:1.5px,color:#14532d;

    subgraph DFD0 ["المخطط الصفري الأكاديمي للنظام (Level-0 DFD Diagram)"]
        
        %% External Entities
        UserExt["المستخدمون (All System Users)"]:::entity
        GitExt["نظام GitHub الخارجي"]:::entity
        DevExt["فريق التطوير والمستشارون"]:::entity
        FinanceExt["الإدارة والعملاء"]:::entity

        %% Processes
        P1(("1.0 <br> إدارة الصلاحيات والتحضير الذكي")):::process
        P2(("2.0 <br> المزامنة أوفلاين وحل التعارض")):::process
        P3(("3.0 <br> أتمتة المهام وتكامل DevOps")):::process
        P4(("4.0 <br> فحص الكود بالـ AI المحلي")):::process
        P5(("5.0 <br> المحاسبة وتقاسم الأرباح")):::process

        %% Data Stores
        D1[("D1: مستودع المستخدمين والعهد")]:::store
        D2[("D2: التخزين المحلي SQLite/Hive")]:::store
        D3[("D3: قاعدة البيانات الرئيسية PostgreSQL")]:::store
        D4[("D4: مستودع المهام والمشاريع")]:::store
        D5[("D5: سجل فحص الجودة والأمان")]:::store
        D6[("D6: سجل الفواتير والعقود والأرباح")]:::store

        %% Data Flows
        UserExt -->|"بيانات التسجيل والحضور والعهد"| P1
        P1 -->|"تحديث البروفايلات وسجل الأجهزة"| D1

        D2 -->|"البيانات أوفلاين المعلقة"| P2
        P2 -->|"تأكيد القيد والمزامنة التلقائية"| D3

        GitExt -->|"Webhook Events & Commits"| P3
        P3 -->|"تحديث حالة المهام والـ Changelog"| D4

        DevExt -->|"الملفات والأكواد المصدريّة"| P4
        P4 -->|"تقرير ثغرات Ollama وجودة الكود"| D5

        FinanceExt -->|"سداد الفواتير ونسب العقود"| P5
        P5 -->|"قيد توزيع الأرباح والتنبؤ المالي"| D6
    end
```

### 10. مخطط العلاقة البينية للكينات ERD والقاموس المنطقي والفيزيائي

#### الشكل (3-3): مخطط العلاقات بين الكيانات الأكاديمي (Academic ERD Diagram)
```mermaid
erDiagram
    USERS ||--o{ PROJECTS : "manages / owns"
    USERS ||--o{ HARDWARE_SPECS : "owns"
    USERS ||--o{ PROFIT_SHARING : "receives"
    USERS ||--o{ ATTENDANCE : "logs"
    PROJECTS ||--|{ TASKS : "contains"
    PROJECTS ||--o{ INVOICES : "generates"
    TASKS ||--o{ AI_CODE_SCANS : "scanned_by"
    
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string role
        int stars_count
        float burnout_level
        timestamp created_at
    }
    PROJECTS {
        bigint id PK
        string name
        bigint client_id FK
        double budget
        string status
        date start_date
        date end_date
    }
    TASKS {
        bigint id PK
        bigint project_id FK
        bigint assigned_to FK
        string title
        string status
        string github_commit_id
    }
    HARDWARE_SPECS {
        bigint id PK
        bigint user_id FK
        string cpu_model
        string ram_capacity
        string gpu_model
        string device_sn UK
    }
    INVOICES {
        bigint id PK
        bigint project_id FK
        double amount
        string status
        date due_date
    }
    PROFIT_SHARING {
        bigint id PK
        bigint project_id FK
        bigint user_id FK
        double percentage
        double amount_paid
    }
    AI_CODE_SCANS {
        bigint id PK
        bigint task_id FK
        text scan_results
        int security_rating
        timestamp scanned_at
    }
    ATTENDANCE {
        bigint id PK
        bigint user_id FK
        timestamp check_in
        timestamp check_out
        float session_duration
    }
```

### 11. لغة النمذجة الموحدة UML

#### الشكل (3-4): مخطط حالات الاستخدام الأكاديمي (Academic Use Case Diagram)
```mermaid
graph LR
    subgraph SystemBoundary ["حدود نظام إدارة ومتابعة المشاريع (System Boundary)"]
        UC_Auth(("تسجيل الدخول والتحقق من التوكن"))
        UC_Progress(("متابعة نسبة الإنجاز والفواتير"))
        UC_Attendance(("تسجيل التحضير وحصر عهد الأجهزة"))
        UC_AIScan(("تشغيل فحص الكود محلياً بالـ AI"))
        UC_Consult(("طلب وتوفير جلسة استشارية"))
        UC_Recruit(("استعراض البروفايلات وتوظيف الفرق"))
        UC_Profit(("أتمتة تقاسم الأرباح والتنبؤ المالي"))
        
        UC_IncludeSync(("تأكيد المزامنة أوفلاين"))
    end
    
    Client["العميل <br> (Client)"]
    Employee["الموظف / المطور <br> (Developer)"]
    Expert["الخبير / المستشار <br> (Consultant)"]
    Recruiter["جهة التوظيف <br> (Recruiter)"]
    Admin["المدير / المشرف <br> (System Admin)"]

    Client --> UC_Auth
    Client --> UC_Progress
    
    Employee --> UC_Auth
    Employee --> UC_Attendance
    Employee --> UC_AIScan
    
    Expert --> UC_Auth
    Expert --> UC_Consult
    
    Recruiter --> UC_Auth
    Recruiter --> UC_Recruit
    
    Admin --> UC_Auth
    Admin --> UC_Profit
    
    UC_Attendance -.->|"<<include>>"| UC_IncludeSync
    UC_AIScan -.->|"<<include>>"| UC_IncludeSync
```

---

## الفصل الرابع: تصميم النظام (System Design)

### 1. خوارزميات النظام (System algorithms)
* خوارزمية تسجيل الدخول والتحقق من الصلاحيات والبوابات.
* خوارزمية مزامنة البيانات وتعيين التعارضات (Offline Sync Algorithm).
* خوارزمية الذكاء الاصطناعي المحلي لفحص الكود والأمان (Ollama Code Analyzer).
* خوارزمية تقاسم الأرباح المحاسبية بناءً على نسب الإنجاز والمبيعات.
* خوارزمية تحليل الإرهاق والعافية المهنية.

### 2. واجهات النظام (System Interfaces)
* تصميم واجهات الشاشات الرئيسية لكل بوابة من البوابات الخمس.
* الشاشات التفاعلية للموظفين والعملاء ومحرك البحث واستعراض الكفاءات.
* تقارير الأداء والفواتير والنشرات التلقائية.

---

## الفصل الخامس: تنفيذ النظام (System Implementation)

### 1. لوحة التحكم للنظام (Control Panel)
توصيف الكود المكتوب بإطار Laravel وتفعيل أدوات DevOps وإدارة السيرفرات.

### 2. شاشة القيادة (Dashboard)
عرض المؤشرات الحيوية للمشاريع والميزانية ومعدل المزامنة.

### 3. شاشات المستخدمين والتطبيقات
عرض واجهات تطبيق Flutter الموبايل والويب أثناء العمل بدون اتصال وفي حالة الاتصال.

### 4. صلاحيات المستخدم (User Permissions)
تحديد الأدوار والتحكم في الوصول الصارم بين أعضاء الفريق وحماية خصوصية الأقران.

---

## الفصول الختامية

### الفصل السادس: النتائج والمناقشات (Results and Discussions)
* تحسين استمرارية العمل بنسبة 100% أثناء انقطاع الشبكة بفضل معمارية Offline-First.
* حماية الأكواد والبيانات من التسريب عبر الفحص المحلي (Ollama).
* خفض النزاعات المالية بين الفرق والشركاء بفضل نظام تقاسم الأرباح المؤتمت.

### الفصل السابع: الاستنتاجات والتوصيات (Conclusions and Recommendations)
* **الاستنتاجات**: تم بناء نموذج متكامل يعالج كافة التحديات التشغيلية والمالية والأمنية للشركات البرمجية الناشئة.
* **التوصيات**: التوسع في تطبيق الذكاء الاصطناعي المحلي وتطوير إضافات برمجية لـ IDEs الشهيرة.

### المراجع (References)
قائمة كاملة بالمراجع العلمية العربية والفيزيائية والروابط المرجعية للمنصات المنافسة.
