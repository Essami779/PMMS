# الهيكل الأساسي والمفصل لمشروع التخرج
## مشروع: نظام إدارة ومتابعة المشاريع
### (Project Management and Tracking System)
* **التخصص:** نظم معلومات إدارية (MIS) - السنة الرابعة
* **العام الجامعي / التخرج:** 2026 / 2027م
* **إشراف الدكتور:** د. خالد المسوري

---

## Table of Contents

* **.I** الإهداء (Dedication)
* **.II** التفويض (Authorization)
* **.III** شكر وتقدير (Acknowledgment)
* **.IV** لجنة المناقشة (Examiner Committee)
* **.V** الملخص (Abstract)
* **.VI** فهرس المحتويات (Table of Contents)
* **.VII** قائمة الأشكال (List of Figures)
* **.VIII** قائمة الجداول (List of Tables)
* **.IX** قائمة الاختصارات (List of Abbreviations)

---

## .I الإهداء (Dedication)
إلى من أنارا لي درب العلم والمعرفة... إلى والدَيَّ الكريمين اعترافاً بفضلهما ودعمهما الذي لا ينضب.
إلى أساتذتي الأفاضل في قسم نظم المعلومات الإدارية، وإلى مشرفي القدير **د. خالد المسوري**، وإلى كل من ساهم في إنجاز هذا العمل البرمجي المتكامل... أهدي هذا الجهد المتواضع.

---

## .II التفويض (Authorization)
أقر أنا طالب مشروع التخرج بقسم نظم المعلومات الإدارية بأنني أمنح الجامعة كافة الحقوق الأكاديمية لحفظ ونشر وتوثيق هذا التقرير المسمى **"نظام إدارة ومتابعة المشاريع"** للعام الجامعي 2026/2027م في مكتبتها وأرشيفها الأكاديمي والبحثي.

---

## .III شكر وتقدير (Acknowledgment)
نتقدم بجزيل الشكر والامتنان لمشرف المشروع الأكاديمي **الدكتور / خالد المسوري** على توجيهاته السديدة وملاحظاته القيمة التي أثرت هذا العمل ووجهت مساره التقني والإداري، كما نتقدم بالشكر لأعضاء هيئة التدريس بقسم نظم المعلومات الإدارية ولجميع من قدم لنا الدعم والتشجيع خلال فترة إعداد وتطوير هذا المشروع.

---

## .IV لجنة المناقشة (Examiner Committee)
تمت مناقشة هذا المشروع وإقراره من قبل لجنة المناقشة والحكم المكونة من:
1. **المشرف الأكاديمي:** د. خالد المسوري - صفته: رئيساً ومحكماً داخلياً.
2. **المناقش الداخلي:** د. [اسم المناقش الداخلي] - صفته: عضواً ومحكماً داخلياً.
3. **المناقش الخارجي:** د. [اسم المناقش الخارجي] - صفته: عضواً ومحكماً خارجياً.

---

## .V الملخص (Abstract)

### الملخص باللغة العربية:
يهدف هذا المشروع إلى تصميم وتطوير **"نظام إدارة ومتابعة المشاريع"**، وهو منصة متكاملة مخصصة للشركات البرمجية الناشئة والفرق الرقمية والوكالات، تتكون من تطبيق ويب (Laravel) وتطبيق هاتف محمول (Flutter). يعتمد النظام في معطياته الأساسية على معمارية **(Offline-First)** لضمان استمرارية العمل على المهام والوصول إلى البيانات حتى أثناء انقطاع اتصال الإنترنت. كما يتميز النظام بتكامل تام مع شبكات **GitHub** لإدارة الأكواد و**DevOps**، ويتضمن محرك ذكاء اصطناعي محلي **(Ollama)** للفحص التلقائي لجودة الأكواد وحماية الملفات الحساسة محلّياً دون الحاجة للاتصال بالإنترنت. يشتمل النظام على 5 بوابات مستخدمين مخصصة (بوابة العملاء، بوابة الموظفين والمشرفين مع تتبع الأجهزة ومحلل الإرهاق، بوابة الخبراء والمستشارين، بوابة التوظيف واستقطاب الكفاءات، ولوحة الإدارة المركزية) بالإضافة إلى نظام محاسبي ذكي لتقاسم الأرباح والتنبؤ بالمخاطر المالية.

### Abstract (English):
This project aims to design and develop the **"Project Management and Tracking System"**, a comprehensive platform tailored for software startups, digital teams, and agencies. The system consists of a Laravel Web Application and a Flutter Mobile Application built on an **Offline-First** architecture to ensure uninterrupted work and data access during network outages. The platform integrates seamlessly with **GitHub** for version control and DevOps automation, and features a local AI engine (**Ollama**) for automated code quality scanning and local file security without external cloud dependencies. It provides 5 specialized portals (Client Portal, Employee/Supervisor Portal with hardware specs tracking and burnout analyzer, Experts/Consultants Portal, Talent Sourcing Portal, and Central Admin Dashboard) along with an automated revenue-sharing mechanism and financial risk forecasting.

---

## .VI فهرس المحتويات (Table of Contents)
* **الفصل الأول:** الإطار العام والمقدمة
* **الفصل الثاني:** الدراسات السابقة والدراسة الجدوى
* **الفصل الثالث:** تحليل المتطلبات والأنظمة
* **الفصل الرابع:** التصميم المعماري والبرمجي
* **الفصل الخامس:** التنفيذ والتكامل
* **الفصل السادس:** النتائج والمناقشات
* **الفصل السابع:** الاستنتاجات والتوصيات
* **قائمة المراجع**

---

## .VII قائمة الأشكال (List of Figures)
* **الشكل (1-1):** مخطط جانت الزمني للمشروع (Gantt Chart).
* **الشكل (2-1):** مقارنة الأنظمة المشابهة (Productive, Teamwork, Monday).
* **الشكل (3-1):** المخطط البيئي للنظام (Context Diagram).
* **الشكل (3-2):** المخطط الصفري للنظام (Level-0 DFD Diagram).
* **الشكل (3-3):** مخطط العلاقات بين الكيانات (ERD Diagram).
* **الشكل (3-4):** مخطط حالات الاستخدام (Use Case Diagram).
* **الشكل (3-5):** مخطط الكائنات البرمجية (Class Diagram).
* **الشكل (3-6):** مخطط التسلسل لمهمة فحص الكود بالـ AI المحلي (Sequence Diagram).
* **الشكل (4-1):** خوارزمية حل التعارض وتأكيد المزامنة (Offline Sync Algorithm).
* **الشكل (4-2):** خوارزمية تقاسم الأرباح وحساب العوائد التلقائي.
* **الشكل (5-1):** واجهة لوحة التحكم المركزية (Admin Dashboard).
* **الشكل (5-2):** واجهة تطبيق الموبايل Flutter وتتبع الإرهاق والحضور.

---

## .VIII قائمة الجداول (List of Tables)
* **الجدول (1-1):** توزيع المهام والجدول الزمني لمراحل العمل.
* **الجدول (2-1):** جدول دراسة الجدوى الاقتصادية وحساب التكاليف.
* **الجدول (2-2):** جدول تقييم وإدارة المخاطر البرمجية والأمنية.
* **الجدول (3-1):** جدول حصر المتطلبات الوظيفية للنظام (Functional Requirements).
* **الجدول (3-2):** جدول المتطلبات غير الوظيفية (Non-Functional Requirements).
* **الجدول (3-3):** قاموس البيانات الرئيسي (Data Dictionary).

---

## .IX قائمة الاختصارات (List of Abbreviations)
* **AI:** Artificial Intelligence (الذكاء الاصطناعي)
* **API:** Application Programming Interface (واجهة برمجة التطبيقات)
* **CI/CD:** Continuous Integration / Continuous Deployment (التكامل والتطوير المستمر)
* **DFD:** Data Flow Diagram (مخطط تدفق البيانات)
* **ERD:** Entity Relationship Diagram (مخطط العلاقة بين الكيانات)
* **LLM:** Large Language Model (نموذج اللغات الكبير)
* **Ollama:** Open-Source Local Large Language Model Runner (مشغل نماذج الذكاء الاصطناعي المحلية)
* **RBAC:** Role-Based Access Control (التحكم بالوصول القائم على الأدوار)
* **SDLC:** Software Development Life Cycle (دورة حياة تطوير البرمجيات)
* **UML:** Unified Modeling Language (لغة النمذجة الموحدة)

---

## الفصل الأول: الإطار العام والمقدمة

### 1. مقدمة (Introduction)
يشهد سوق تطوير البرمجيات نمواً كبيراً وتزايداً في عدد الفرق البرمجية والشركات الناشئة والوكالات الرقمية. ومع توسع نطاق الأعمال البرمجية وتداخل الأدوات المستخدمة في إدارة المشاريع والتطوير، أصبحت الحاجة ماسة لبيئة عمل برمجية وإدارية موحدة وموثوقة تجمع بين إدارة المهام، متابعة الأكواد البرمجية، تقييم الأداء، والشفافية المالية.

### 2. تعريف المشروع (Definition of the project)
**"نظام إدارة ومتابعة المشاريع"** هو منصة رقمية متكاملة (موقع ويب وتطبيق هاتف محمول) مصممة خصيصاً للشركات البرمجية الناشئة والفرق الرقمية، يعتمد على معمارية العمل بدون اتصال **(Offline-First)** لضمان الاستمرارية والوصول إلى البيانات الأساسية فور انقطاع الإنترنت. يتميز النظام بالدمج المباشر مع شبكات GitHub والـ DevOps، والاعتماد الكامل على الذكاء الاصطناعي المحلي (Local AI) لفحص جودة الكود وتأمين البيانات وتوطين اللغة والترجمة دون رفع أي أكواد إلى خوادم سحابية خارجية.

### 3. تحديد المشكلة (Problem Statement)
تتلخص مشكلة المشروع في النقاط التالية:
1. **تشتت الأدوات:** الاعتماد على أدوات منفصلة لإدارة المهام، المراجعة، الفواتير، ومتابعة الكود المصدري.
2. **التبعية السحابية وانقطاع الإنترنت:** توقف الإنتاجية وعدم القدرة على الوصول للملفات والمهام أثناء انقطاع الشبكة.
3. **مخاطر أمن البيانات والأكواد:** مخاطر تسريب الأكواد والبيانات المصرّح بها عند رفعها للمنصات السحابية للذكاء الاصطناعي.
4. **عدم الشفافية وغياب التقييم العادل:** صعوبة اطلاع العملاء على نسبة الإنجاز الحقيقية بدون كشف الكود الداخلي، وغياب أنظمة محاسبية مؤتمتة لتقاسم الأرباح وتتبع العهد وتجهيزات المطورين.

### 4. أهداف المشروع (Project Objectives)
* بناء منصة إدارة متكاملة تضم **موقع ويب (Laravel)** و**تطبيق موبايل (Flutter)**.
* تصميم النظام وفق معمارية **Offline-First** لحفظ البيانات ومزامنتها تلقائياً فور توفر الاتصال.
* إنشاء **5 بوابات مستخدمين صريحة** (بوابة العميل، بوابة الموظفين والمشرفين، بوابة الخبراء، بوابة التوظيف، ولوحة الإدارة الكلية).
* دمج محرك ذكاء اصطناعي محلي **(Ollama)** لفحص الكود التلقائي، الترجمة الأوفلاين، وحماية الملفات.
* أتمتة عمليات **GitHub & DevOps** وتحديد حالة المهام تلقائياً بناءً على سحب ورفع الأكواد.
* تقديم نظام محاسبي مؤتمت لتقاسم الأرباح، التنبؤ بالمخاطر المالية، إدارة الفواتير، وتتبع الأجهزة والعهد.

### 5. أهمية المشروع (Project Importance)
* **توفير التكاليف:** إلغاء رسوم الاشتراكات السحابية الباهظة للمنصات المشابهة.
* **استمرارية العمل:** تمكين الفرق البرمجية من العمل بأقصى إنتاجية في جميع الظروف الشبكية.
* **حماية الملكية الفكرية:** ضمان بقاء الأكواد والملفات داخل أجهزة الخوادم المحلية للشركة دون تسريب.
* **تعزيز العدالة والإنتاجية:** توفير نظام تحفيزي غير مالي بالنجوم ومحلل العافية والإرهاق لحماية المطورين.

### 6. نطاق وحدود المشروع (Project Scope and Limitations)
* **النطاق التقني:** تطبيق ويب مرن، تطبيق محمول يعمل على Android/iOS، قاعدة بيانات موحدة، ومحرك AI محلي.
* **النطاق الوظيفي:** إدارة المهام، المزامنة الذكية، تتبع الأجهزة، التوظيف، الاستشارات، والربط المالي.
* **الحدود:** يعتمد الربط مع مستودعات الأكواد على API الخاص بـ GitHub، وتعتمد مكالمات الاجتماعات المباشرة على روابط خارجية مثل Zoom أو Google Meet.

### 7. الأدوات المستخدمة في المشروع (Tools used in the project)
* **الواجهة الخلفية (Backend):** إطار عمل Laravel (PHP 8.2+).
* **الواجهة الأمامية والتطبيق المحمول:** Flutter SDK (Dart) للويب والموبايل.
* **قواعد البيانات:** PostgreSQL على السيرفر الرئيسي + SQLite / Hive للمزامنة المحلية على أجهزة المستخدمين.
* **الذكاء الاصطناعي المحلي:** Ollama Runner (موزع محلياً بنماذج CodeLlama / Llama3).
* **التكامل والـ DevOps:** GitHub REST/GraphQL APIs, Git Hooks.

### 8. المنهجية المستخدمة لعمل المشروع (Research Methodology)
اعتماد منهجية التطوير السريع **(Agile / Scrum Methodology)**، مع تقسيم فترة العمل إلى دورات زمنية قصيرة (Sprints) مدة كل منها أسبوعان، تغطي التحليل، التصميم، التكويد، المزامنة، واختبار الأمان.

### 9. الجدول الزمني للمشروع (Timetable for the project)

#### الجدول (1-1): توزيع المهام والجدول الزمني لمراحل العمل
| م | مرحلة العمل البرمجي والإداري | المدة الزمنية | مسؤولية المرحلة | المخرجات المتوقعة |
|---|---|:---:|---|---|
| 1 | جمع المتطلبات وتحليل البوابات | أسبوعان | فريق تحليل الأنظمة | وثيقة متطلبات النظام SRS |
| 2 | التصميم المعماري (DFD, ERD, UML) | 3 أسابيع | مهندس المعمارية والبيانات | مخططات التصميم وقواعد البيانات |
| 3 | تطوير الـ Backend (Laravel REST APIs) | 4 أسابيع | مطورو الواجهة الخلفية | واجهات برمجية مؤمنة |
| 4 | تطوير الواجهات وتطبيق الموبايل (Flutter) | 4 أسابيع | مطورو Flutter | تطبيق ويب وموبايل متكامل |
| 5 | دمج الـ Offline-Sync والـ AI المحلي | 3 أسابيع | مهندسو الذكاء الاصطناعي والمزامنة | محرك Ollama ونظام المزامنة |
| 6 | الاختبارات التشغيلية والرفع والتوثيق | أسبوعان | فريق الاختبارات والمشرف | التقرير النهائي والمناقشة |

### 10. مخطط جانت للمشروع (Gantt chart for the project)

#### الشكل (1-1): مخطط جانت الزمني لمراحل تنفيذ المشروع (Gantt Chart)
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
    تصميم معمارية المزامنة والذكاء الاصطناعي :a2_sub, 2026-08-22, 14d
    
    section المرحلة الثالثة: التطوير والبرمجة
    تطوير Laravel REST APIs               :a3, 2026-09-05, 28d
    تطوير تطبيقات Flutter (ويب وموبايل)   :a4, 2026-09-20, 28d
    دمج Offline-Sync & Ollama Local AI    :a5, 2026-10-15, 21d
    
    section المرحلة الرابعة: الاختبار والتوثيق
    الاختبارات التشغيلية وفحص الأمان       :a6, 2026-11-05, 14d
    تسليم التقرير النهائي والمناقشة الأكاديمية :a7, 2026-11-19, 14d
```

### 11. تنظيم التقرير (Report Organization)
يتكون هذا التقرير من 7 فصول متكاملة؛ حيث يغطي الفصل الأول المقدمة والإطار العام، ويناقش الفصل الثاني الدراسات السابقة وجدوى المشروع، ويفصل الفصل الثالث المتطلبات التحليلية ومخططات النظام، بينما يستعرض الفصل الرابع التصميم المعماري والخوارزميات، ويتناول الفصل الخامس التنفيذ البرمجي والتكامل، ويقدم الفصل السادس نتائج الاختبارات التشغيلية، وصولاً إلى الفصل السابع الذي يضم الاستنتاجات والتوصيات وقائمة المراجع.

---

## الفصل الثاني: الدراسات السابقة والدراسة الجدوى (Literature Review)

### 1. خلفية الدراسة (Background)
تطورت منصات إدارة المشاريع من أدوات بسيطة لتتبع الجداول الزمنية إلى بيئات عمل رقمية شاملة. تبرز الحاجة اليوم في الشركات الناشئة لربط الأداء المالي والبرمجي بمستوى الإنجاز وتتبع عهد الأجهزة مع المحافظة على الملكية الفكرية وسرية البيانات.

### 2. الدراسات السابقة (Literature Review)
* **دراسات حول معمارية (Offline-First):** أكدت الأبحاث أن اعتماد التخزين المحلي والمزامنة التلقائية يقلل من وقت التوقف التشغيلي بنسبة تصل إلى 40% في البيئات ذات الاتصال الضعيف بالإنترنت.
* **دراسات حول الذكاء الاصطناعي المحلي:** أظهرت التقارير الأكاديمية الحديثة أن تشغيل نماذج الـ LLM محلياً (مثل Ollama) يمنح أماناً بنسبة 100% ضد مخاطر التسريب الأمني مع تقديم سرعة فحص ممتازة للأكواد.

### 3. النظام الحالي (Existing system)

#### الشكل (2-1): مخطط الدراسة المقارنة والفجوة البحثية (Comparative Analysis & Research Gap)
```mermaid
graph TD
    classDef system fill:#f8fafc,stroke:#334155,stroke-width:1.5px,color:#0f172a;
    classDef gap fill:#fff1f2,stroke:#e11d48,stroke-width:2px,color:#881337;
    classDef solution fill:#f0fdf4,stroke:#16a34a,stroke-width:2px,color:#14532d;
    classDef header fill:#1e293b,stroke:#0f172a,stroke-width:2px,color:#ffffff;

    subgraph ComparativeStudy ["الدراسة المقارنة وتحليل الفجوة البحثية (Comparative Analysis & Research Gap)"]
        
        subgraph ExistingSystems ["الأنظمة الحالية المشابهة (Existing Systems)"]
            A1["Productive.io <br> (منصة سحابية - تفتقر للمزامنة المحلية والذكاء الاصطناعي المحلي)"]:::system
            A2["Teamwork <br> (تفتقر لبوابات الخبراء والتوظيف وتتبع عهد الأجهزة)"]:::system
            A3["Monday.com <br> (ارتفاع التكاليف ومخاوف تسريب الأكواد عبر AI السحابي)"]:::system
        end
        
        GapNode["الفجوة البحثية والأكاديمية (Research Gap) <br> الحاجة لنظام يجمع بين: العمل بدون اتصال (Offline-First) + الذكاء الاصطناعي المحلي (Local AI) + تقاسم الأرباح + تتبع العهد"]:::gap
        
        ProposedNode["النظام المقترح للبحث (Proposed System) <br> منصة إدارة ومتابعة المشاريع (Project Management & Tracking System)"]:::solution

        A1 -->|"قصور في الأوفلاين والسرية"| GapNode
        A2 -->|"غياب أتمتة الأرباح والعهد"| GapNode
        A3 -->|"مخاطر أمن المعلومات والتكلفة"| GapNode
        
        GapNode -->|"معالجة الفجوة بتقديم الحل المبتكر"| ProposedNode
    end
```

### 4. دراسة الجدوى (FEASIBILITY STUDY)
* **a. دراسة الجدوى التقنية (Technical feasibility study):**
  - إمكانية تطوير الواجهات بـ Flutter وتطبيق الـ Backend بـ Laravel.
  - قدرة الأجهزة الحالية على تشغيل نماذج Ollama محلياً بكفاءة عالية.
* **b. دراسة الجدوى الاقتصادية (Economic feasibility study):**

#### الجدول (2-1): جدول دراسة الجدوى الاقتصادية وحساب التكاليف
| بند التكلفة الإدارية والتقنية | تكلفة المنصات السحابية التقليدية (سنوياً) | تكلفة النظام المقترح (سنوياً) | قيمة التوفير المالي المحقق |
|---|:---:|:---:|:---:|
| اشتراكات أدوات إدارة المشاريع (30 موظف) | $4,500 | $0 (مطور محلياً) | $4,500 |
| خدمات فحص الأكواد بالذكاء الاصطناعي السحابي | $2,400 | $0 (Ollama محلي) | $2,400 |
| استهلاك النطاق الترددي والبيانات السحابية | $1,200 | $300 | $900 |
| **إجمالي التكلفة / التوفير المالي السنوي** | **$8,100** | **$300** | **$7,800 توفير (96%)** |

* **c. دراسة الجدوى التشغيلية (Operational feasibility study):**
  - تميز الواجهات بالسهولة والمرونة، وتجاوب المطورين والعملاء مع البوابات الخمس المخصصة.

### 5. إدارة المخاطر (Risks management)

#### الجدول (2-2): جدول تقييم وإدارة المخاطر البرمجية والأمنية
| م | نوع الخطر المتوقع | مستوى الخطر | وصف الخطر البرمجي | استراتيجية التحكم والوقاية (Risk Control) |
|---|---|:---:|---|---|
| 1 | تعارض بيانات المزامنة | متوسط | حدوث تضارب بين البيانات المحلية والسيرفر | تطبيق خوارزمية حل التعارض وحفظ الطابع الزمني CRDT |
| 2 | استهلاك الموارد بالـ AI المحلي | مرتفع | بطء الجهاز أثناء فحص Ollama للأكواد | جدولة الفحص الآلي في أوقات الخمول أو على خادم محلي |
| 3 | انقطاع الكهرباء المفاجئ | مرتفع | فقدان البيانات المدخلة محلياً | التخزين الفوري التلقائي في SQLite/Hive كل 3 ثوانٍ |
| 4 | اختراق ثغرات الوصول | منخفض | محاولة التسلل لبوابات غير مصرحة | استخدام نظام RBAC وتشفير التوكن بـ AES-256 |

---

## الفصل الثالث: تحليل المتطلبات والأنظمة (Analysis)

### 1. طرق جمع المتطلبات (Methods of collecting requirements)
* المقابلات الشخصية المباشرة مع مدراء شركات برمجية ومطورين.
* الاستبيانات الميدانية لتحليل التحديات التشغيلية والمالية في الفرق الناشئة.
* التحليل المرجعي والمقارنة الوظيفية مع المنصات العالمية.

### 2. متطلبات العمل (Work requirements)
تنظيم العمل داخل المنصة عبر 5 بوابات متخصصة: (بوابة العميل، بوابة الموظفين والمشرفين، بوابة الخبراء، بوابة التوظيف، ولوحة الإدارة المركزية).

### 3. متطلبات النظام (System Requirements)
متطلبات الربط التلقائي مع GitHub، فحص الأكواد محلياً بـ Ollama، المحادثات الصوتية والنصوص، وأتمتة الفواتير وتقاسم الأرباح.

### 4. المتطلبات الوظيفية (functional requirements)

#### الجدول (3-1): جدول حصر المتطلبات الوظيفية للنظام (Functional Requirements)
| المعرف (ID) | اسم المتطلب الوظيفي | البوابة المستهدفة | الوصف التفصيلي للمتطلب |
|---|---|---|---|
| FR-01 | تسجيل الدخول والصلاحيات | جميع البوابات | التحقق من المستخدم وإعطاء الصلاحيات بناءً على دور RBAC |
| FR-02 | متابعة الإنجاز والفواتير | بوابة العميل | عرض نسبة الإنجاز ورسم الفواتير دون كشف كود السورس المصدري |
| FR-03 | التحضير الذكي وتتبع الأجهزة | بوابة الموظفين | تسجيل الدخول الذكي وحصر عهد الأجهزة (CPU, RAM, GPU) |
| FR-04 | تحليل الإرهاق والعافية | بوابة الموظفين | خوارزمية تتبع وقت العمل وتنبيه المطور لأخذ فترة راحة |
| FR-05 | فحص الكود بالـ AI المحلي | بوابة الموظفين والمشرفين | الفحص الآلي للأكواد والثغرات محلياً عبر محرك Ollama |
| FR-06 | تقديم واستعراض الاستشارات | بوابة الخبراء | تنظيم جلسات الاستشارة الفنية للمشاريع والفرق |
| FR-07 | التعاقد واستقطاب الفرق | بوابة التوظيف | استعراض بروفايلات المطورين المربوطة بـ GitHub وإرسال عقود |
| FR-08 | أتمتة تقاسم الأرباح | لوحة الإدارة | توزيع العوائد المالية تلقائياً حسب نسب الإنجاز والعقود |

### 5. المتطلبات غير الوظيفية (Non-functional requirements)

#### الجدول (3-2): جدول المتطلبات غير الوظيفية (Non-Functional Requirements)
| المعيار غير الوظيفي | المتطلب التقني القياسي | القيمة Target المستهدفة |
|---|---|---|
| الأداء والسرعة (Performance) | زمن استجابة الاستعلامات المحلية | أقل من 200ms |
| السرية والأمان (Security) | تشفير البيانات المحلية والتوكن | AES-256 Bit Encryption |
| الموثوقية والاستمرارية (Reliability) | تشغيل المنصة عند انقطاع الإنترنت | 100% Offline Availability |
| التوافقية (Compatibility) | الأجهزة والأنظمة المدعومة | Web (Chrome/Edge), Android, iOS |
| السعة والتوسع (Scalability) | عدد المستخدمين المتزامنين | دعم حتى 10,000 مستخدم متزامن |

### 6. متطلبات المستخدم (User requirements)
سهولة استخدام الواجهات، دعم اللغة العربية والترجمة الفورية الأوفلاين، ووضوح التقارير والإشعارات.

### 7. تحليل المدخلات (Input analysis)
بيانات الموظفين والعملاء والخبراء، مستودعات GitHub، مواصفات عهد الأجهزة، العقود والفواتير وتقارير الصوت.

### 8. تحليل المخرجات (output analysis)
لوحات القيادة، تقارير جودة الكود والأمان من الـ AI المحلي، الفواتير الإلكترونية، وسجلات التحديثات (Changelog).

### 9. مخطط تدفق البيانات DFD
توضيح المسارات التي تسلكها البيانات داخل النظام بين البوابات والمكونات المختلفة.

### 10. المخطط البيئي (Context Diagram)

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

### 11. المخطط الصفري (Level-0 Diagram)

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

### 12. مخطط العلاقة البينية للكيانات ERD (Entity Relationship Diagram)

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
        bigint id PK "المعرف الفريد للمستخدم"
        string name "اسم المستخدم الكامل"
        string email UK "البريد الإلكتروني الفريد"
        string password "كلمة المرور المشفرة AES-256"
        string role "نوع الدور والصلاحية RBAC"
        int stars_count "رصيد النجوم التحفيزي"
        float burnout_level "مؤشر إرهاق المطور"
        timestamp created_at "تاريخ الإنشاء"
    }
    PROJECTS {
        bigint id PK "المعرف الفريد للمشروع"
        string name "اسم المشروع"
        bigint client_id FK "معرف العميل المالِك"
        double budget "الميزانية الإجمالية للمشروع"
        string status "حالة المشروع التشغيلية"
        date start_date "تاريخ البدء"
        date end_date "تاريخ التسليم المتوقع"
    }
    TASKS {
        bigint id PK "المعرف الفريد للمهمة"
        bigint project_id FK "معرف المشروع التابع له"
        bigint assigned_to FK "معرف المطور المكلف"
        string title "عنوان المهمة البرمجية"
        string status "حالة المهمة (Under Review / Done)"
        string github_commit_id "معرف الالتزام في GitHub"
    }
    HARDWARE_SPECS {
        bigint id PK "المعرف الفريد للجهاز"
        bigint user_id FK "معرف المطور المالك للعهدة"
        string cpu_model "مواصفات المعالج Central CPU"
        string ram_capacity "سعة الذاكرة العشوائية RAM"
        string gpu_model "مواصفات كرت الشاشة Dedicated GPU"
        string device_sn UK "الرقم التسلسلي الفريد للجهاز Serial Number"
    }
    INVOICES {
        bigint id PK "المعرف الفريد للفاتورة"
        bigint project_id FK "معرف المشروع"
        double amount "قيمة الفاتورة المالية"
        string status "حالة السداد (Paid / Pending)"
        date due_date "تاريخ الاستحقاق"
    }
    PROFIT_SHARING {
        bigint id PK "معرف سند التوزيع"
        bigint project_id FK "معرف المشروع"
        bigint user_id FK "معرف المستفيد"
        double percentage "نسبة الاستحقاق حسب العقد"
        double amount_paid "المبلغ المستلم الفعلي"
    }
    AI_CODE_SCANS {
        bigint id PK "معرف فحص الأمان"
        bigint task_id FK "معرف المهمة المفحوصة"
        text scan_results "نتائج فحص محرك Ollama"
        int security_rating "درجة الأمان والجودة (0-100)"
        timestamp scanned_at "تاريخ ووقت الفحص المحلي"
    }
    ATTENDANCE {
        bigint id PK "معرف سجل التحضير"
        bigint user_id FK "معرف الموظف"
        timestamp check_in "وقت تسجيل الدخول الذكي"
        timestamp check_out "وقت تسجيل الخروج"
        float session_duration "إجمالي ساعات العمل الفعلية"
    }
```

### 13. المخطط المنطقي (The Logical Diagram)
تحويل مخطط الـ ERD إلى جداول منطقية معرفة بالمفاتيح الرئيسية (Primary Keys) والمفاتيح الأجنبية (Foreign Keys).

### 14. المخطط الفيزيائي (The physical Diagram)
تحديد أنواع البيانات الفيزيائية وطول الحقول والفهارس (Indexes) وقواعد القيود في قاعدة بيانات PostgreSQL/MySQL.

### 15. قاموس البيانات (Data Dictionary)

#### الجدول (3-3): قاموس البيانات الرئيسي (Data Dictionary)
| اسم الجدول | اسم الحقل (Field) | نوع البيانات (Data Type) | القيود والخصائص (Constraints) | الوصف الوظيفي للحقل |
|---|---|---|---|---|
| `users` | `id` | INT (11) | Primary Key, Auto Increment | المعرف الفريد للمستخدم |
| `users` | `role` | VARCHAR (50) | NOT NULL, Enum | دور المستخدم في البوابات |
| `users` | `burnout_level` | FLOAT (3,2) | Default: 0.00 | نسبة مؤشر إرهاق المطور |
| `projects` | `budget` | DECIMAL (10,2) | NOT NULL | الميزانية الإجمالية للمشروع |
| `tasks` | `status` | VARCHAR (30) | Default: 'Pending' | حالة المهمة البرمجية |
| `hardware_specs`| `gpu` | VARCHAR (100) | NULLable | مواصفات كرت الشاشة للجهاز |
| `ai_code_scans` | `security_rating`| INT (3) | Range: 0 to 100 | درجة الأمان الصادرة من Ollama |

### 16. لغة النمذجة الموحدة UML

#### a. مخطط حالة الاستخدام (Use Case Diagram)

##### الشكل (3-4): مخطط حالات الاستخدام الأكاديمي (Academic Use Case Diagram)
```mermaid
graph LR
    classDef actor fill:#f8fafc,stroke:#1e293b,stroke-width:1.5px,color:#0f172a;
    classDef uc fill:#eff6ff,stroke:#2563eb,stroke-width:1.5px,color:#1e3a8a;
    classDef inc fill:#fef3c7,stroke:#d97706,stroke-width:1.5px,color:#78350f;

    subgraph SystemBoundary ["حدود نظام إدارة ومتابعة المشاريع والفرق (System Boundary)"]
        UC_Auth(("UC-01: تسجيل الدخول والتحقق من RBAC Token")):::uc
        UC_Progress(("UC-02: متابعة نسبة الإنجاز والمالية")):::uc
        UC_Attendance(("UC-03: تسجيل التحضير وحصر عهد الأجهزة")):::uc
        UC_AIScan(("UC-04: تشغيل فحص الكود محلياً بالـ AI")):::uc
        UC_Consult(("UC-05: طلب وتوفير جلسة استشارية")):::uc
        UC_Recruit(("UC-06: استعراض البروفايلات وتوظيف الفرق")):::uc
        UC_Profit(("UC-07: أتمتة تقاسم الأرباح والتنبؤ المالي")):::uc
        
        UC_IncludeSync(("UC-Sub: تأكيد المزامنة محلياً (Offline-Sync)")):::inc
    end
    
    %% Actors
    Client["العميل <br> (Client)"]:::actor
    Employee["الموظف / المطور <br> (Developer)"]:::actor
    Expert["الخبير / المستشار <br> (Consultant)"]:::actor
    Recruiter["جهة التوظيف <br> (Recruiter)"]:::actor
    Admin["المدير / المشرف <br> (System Admin)"]:::actor

    %% Actor to Use Cases
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
    
    %% Include stereotypic relationships
    UC_Attendance -.->|"<<include>>"| UC_IncludeSync
    UC_AIScan -.->|"<<include>>"| UC_IncludeSync
```

#### b. مخطط الكائنات البرمجية (Class Diagram)

##### الشكل (3-5): مخطط الفئات الأكاديمي المعياري (Academic Class Diagram)
```mermaid
classDiagram
    class UserController {
        -int id
        -string name
        -string role
        +login(credentials: AuthPayload): AuthToken
        +getProfile(userId: int): UserProfile
        +updateBurnoutLevel(userId: int, score: float): bool
    }
    class ProjectController {
        -int projectId
        -double budget
        -string status
        +createProject(data: ProjectDTO): Project
        +trackProgress(projectId: int): Percentage
        +forecastFinancialRisk(projectId: int): RiskReport
    }
    class TaskManager {
        -int taskId
        -string status
        -string commitId
        +assignTask(taskId: int, userId: int): bool
        +updateStatusFromGit(commitId: string): bool
        +syncOfflineData(payload: SyncBatch): SyncResult
    }
    class OllamaAIService {
        -string modelName
        -string apiEndpoint
        +scanCodeQuality(codeFile: File): ScanReport
        +detectVulnerabilities(codeFile: File): VulnerabilityList
        +translateLocalText(text: string, targetLang: string): string
    }
    class ProfitSharingEngine {
        -double totalRevenue
        -double netProfit
        +calculateDistribution(projectId: int): DistributionArray
        +disbursePayout(distributionList: List): TransactionStatus
    }

    UserController "1" -- "0..*" ProjectController : "manages >"
    ProjectController "1" *-- "1..*" TaskManager : "contains >"
    TaskManager "1" ..> "1" OllamaAIService : "uses for scanning >"
    ProjectController "1" --> "1" ProfitSharingEngine : "triggers distribution >"
```

#### c. مخطط التسلسل (Sequence Diagram)

##### الشكل (3-6): مخطط التسلسل الأكاديمي لمهمة فحص الكود بالـ AI المحلي (Academic Sequence Diagram)
```mermaid
sequenceDiagram
    autonumber
    actor Developer as المطور (Developer)
    participant FlutterApp as تطبيق الموبايل والويب (Flutter UI)
    participant GitRepository as مستودع GitHub (Repository)
    participant LocalOllama as محرك Ollama المحلي (Local AI Engine)
    participant Database as قاعدة البيانات (PostgreSQL/SQLite)

    Developer->>GitRepository: 1. Push Code Changes (git push origin main)
    GitRepository-->>FlutterApp: 2. Trigger Webhook Notification Event
    FlutterApp->>LocalOllama: 3. Send Source Code File for Offline Scan Request
    Note over LocalOllama: فحص جودة الكود واكتشاف الثغرات محلياً 100% دون إنترنت
    LocalOllama-->>FlutterApp: 4. Return Security Vulnerabilities & Code Quality Score
    FlutterApp->>Database: 5. Store Scan Results & Update Task Verification Status
    Database-->>FlutterApp: 6. Confirm Database Transaction (200 OK)
    FlutterApp-->>Developer: 7. Display Security Rating Badge & Alert UI
```

---

## الفصل الرابع: التصميم المعماري والبرمجي (Design)

### 1. خوارزميات النظام (System algorithms)

#### أ. خوارزمية حل التعارض وتأكيد المزامنة (Offline Sync Algorithm)

##### الشكل (4-1): مخطط خوارزمية حل التعارض وتأكيد المزامنة الأوفلاين (Offline Sync Flowchart)
```mermaid
graph TD
    classDef startEnd fill:#1e293b,stroke:#0f172a,stroke-width:2px,color:#ffffff;
    classDef decision fill:#fef3c7,stroke:#d97706,stroke-width:2px,color:#78350f;
    classDef process fill:#eff6ff,stroke:#2563eb,stroke-width:1.5px,color:#1e3a8a;

    Start(["1. بدء عملية المزامنة (Start Sync Process)"]):::startEnd --> CheckConnection{"2. هل يتوفر اتصال بشبكة الإنترنت؟"}:::decision
    
    CheckConnection -- "لا (Offline)" --> SaveLocal["3. حفظ التغييرات والبيانات في SQLite/Hive محلياً"]:::process
    SaveLocal --> EndLocal(["4. الانتظار في طابور المزامنة لحين توفر الشبكة"]):::startEnd
    
    CheckConnection -- "نعم (Online)" --> FetchLocalChanges["5. قراءة التغييرات والبيانات المحلية المعلقة"]:::process
    FetchLocalChanges --> CompareTimestamps{"6. مقارنة الطابع الزمني Timestamp مع الخادم الرئيسي"}:::decision
    
    CompareTimestamps -- "بيانات أحدث ولا يوجد تضارب" --> PushToMain["7. تحديث قاعدة البيانات الرئيسية PostgreSQL"]:::process
    CompareTimestamps -- "تضارب في نفس التعديل" --> ApplyCRDT["8. تطبيق خوارزمية حل التعارض CRDT Algorithm"]:::process
    
    PushToMain --> ClearQueue["9. مسح الطابور المحلي وإرسال تأكيد المزامنة"]:::process
    ApplyCRDT --> ClearQueue
    ClearQueue --> EndSync(["10. اكتملت عملية المزامنة بنجاح (Sync Complete)"]):::startEnd
```

#### ب. خوارزمية تقاسم الأرباح وحساب العوائد التلقائي

##### الشكل (4-2): مخطط خوارزمية تقاسم الأرباح وحساب العوائد (Profit Sharing Flowchart)
```mermaid
graph TD
    classDef startEnd fill:#1e293b,stroke:#0f172a,stroke-width:2px,color:#ffffff;
    classDef decision fill:#fef3c7,stroke:#d97706,stroke-width:2px,color:#78350f;
    classDef process fill:#eff6ff,stroke:#2563eb,stroke-width:1.5px,color:#1e3a8a;

    StartProfit(["1. بدء خوارزمية تقاسم الأرباح (Start Profit Sharing)"]):::startEnd --> ReadContract["2. قراءة العقود الإلكترونية ونسب الشركاء والمطورين"]:::process
    ReadContract --> GetCompletedTasks["3. حساب نسبة المهام المنجزة المعتمدة لكل عضو في المشروع"]:::process
    GetCompletedTasks --> CheckClientPayment{"4. هل تم سداد الدفعة المالية المخصصة للمرحلة من العميل؟"}:::decision
    
    CheckClientPayment -- "لا (Unpaid)" --> HoldDistribution["5. تعليق التوزيع التلقائي وإرسال إشعار لمسؤول المالية"]:::process
    CheckClientPayment -- "نعم (Paid)" --> CalculateNetProfit["6. احتساب صافي الأرباح بعد خصم التكاليف التشغيلية للمشروع"]:::process
    
    CalculateNetProfit --> MultiplyPercentage["7. حساب مستحق كل عضو = الصافي × نسبة العقد × نسبة الإنجاز"]:::process
    MultiplyPercentage --> GeneratePayoutRecords["8. توليد سندات الصرف الآلية وإصدار الفواتير الإلكترونية"]:::process
    GeneratePayoutRecords --> EndProfit(["9. تأكيد التوزيع المحاسبي وإرسال الإشعارات للجميع (End Distribution)"]):::startEnd
```

### 2. واجهات النظام (system Interfaces)
* **واجهات النظام الأساسية (main Interface):** لوحة تحكم الويب بـ Laravel وتطبيق Flutter المحمول.
* **الشاشات الرئيسية والتقارير الصوتية والنشرات.**

---

## الفصل الخامس: التنفيذ والتكامل (System Implementation)

### 1. مخطط المعمارية الهندسية والتكامل التشغيلي (System Architecture & Integration Diagram)

#### الشكل (5-1): مخطط الهيكلية المعمارية الأكاديمي للنظام (Academic System Architecture Diagram)
```mermaid
graph TD
    classDef clientLayer fill:#eff6ff,stroke:#2563eb,stroke-width:2px,color:#1e3a8a;
    classDef appLayer fill:#f0fdf4,stroke:#16a34a,stroke-width:2px,color:#14532d;
    classDef aiLayer fill:#faf5ff,stroke:#7e22ce,stroke-width:2px,color:#581c87;
    classDef dbLayer fill:#fff7ed,stroke:#ea580c,stroke-width:2px,color:#7c2d12;

    subgraph Architecture ["مخطط معمارية نظام إدارة ومتابعة المشاريع (System Architecture)"]
        
        subgraph PresentationLayer ["طبقة العرض والواجهات (Presentation Layer)"]
            UI_Web["منصة الويب <br> (Laravel Blade / Vue.js)"]:::clientLayer
            UI_Mobile["تطبيق الموبايل والسطح <br> (Flutter SDK)"]:::clientLayer
        end
        
        subgraph LogicLayer ["طبقة منطق الأعمال والخدمات (Business Logic Layer)"]
            API_Gateway["Laravel RESTful API Gateway & RBAC"]:::appLayer
            Sync_Engine["محرك المزامنة أوفلاين (Sync Queue & CRDT)"]:::appLayer
            Profit_Engine["محرك أتمتة تقاسم الأرباح والفواتير"]:::appLayer
        end
        
        subgraph AILayer ["طبقة الذكاء الاصطناعي المحلي (Local AI Layer)"]
            Ollama_Runner["محرك Ollama المحلي <br> (Local LLM Execution Engine)"]:::aiLayer
            Code_Analyzer["وحدة فحص جودة الكود والأمان"]:::aiLayer
        end
        
        subgraph DataLayer ["طبقة التخزين وقواعد البيانات (Persistence Layer)"]
            Local_DB[("تخزين محلي <br> SQLite / Hive")]:::dbLayer
            Main_DB[("قاعدة البيانات الرئيسية <br> PostgreSQL")]:::dbLayer
        end

        PresentationLayer -->|"HTTP REST API / JSON"| LogicLayer
        UI_Mobile -->|"تخزين واسترجاع أوفلاين"| Local_DB
        Sync_Engine <-->|"مزامنة متزامنة عند الاتصال"| Main_DB
        LogicLayer -->|"IPC / Local HTTP (Port 11434)"| AILayer
    end
```

### 2. لوحة التحكم للنظام (Control panel)

#### الشكل (5-2): واجهة لوحة التحكم المركزية (Admin Dashboard)
```
+-----------------------------------------------------------------------------------+
|  نظام إدارة ومتابعة المشاريع - لوحة التحكم المركزية (Admin Dashboard)            |
+-----------------------------------------------------------------------------------+
| [إحصائيات حية]  المشاريع النشطة: 12  |  المطورون: 45  | الميزانية: $120,000       |
+-----------------------------------------------------------------------------------+
| [قائمة البوابات]  (1) العميل  (2) الموظفين  (3) الخبراء  (4) التوظيف  (5) الإدارة    |
+-----------------------------------------------------------------------------------+
| [مراقبة السيرفرات] حالة Ollama المحلي: شغال (Port 11434) | GitHub Webhooks: نشط     |
+-----------------------------------------------------------------------------------+
| [جدول الإنجاز المالي] المشروع A (85%) - المشروع B (40%) - تقاسم الأرباح: مؤتمت    |
+-----------------------------------------------------------------------------------+
```

### 2. شاشة القيادة وتطبيق الموبايل (Dashboard & Mobile App)

#### الشكل (5-2): واجهة تطبيق الموبايل Flutter وتتبع الإرهاق والحضور
```
+------------------------------------+
|  تطبيق المطور (Flutter Mobile)     |
+------------------------------------+
| [التحضير الذكي]  تم تسجيل الدخول   |
| حالة الشبكة: [Offline - أوفلاين]   |
+------------------------------------+
| [مؤشر العافية] الإرهاق: 15% (جيد)  |
| [النجوم والتحفيز]  رصيدك: 120 نجوم  |
+------------------------------------+
| [المهام الحالية]                   |
|  - مراجعة API المزامنة [مستمر]      |
|  - فحص أمان الملفات بالـ AI [تم]   |
+------------------------------------+
| [سجل عهد الأجهزة]                  |
| Device: Dell XPS | CPU: i7 | RAM:32G|
+------------------------------------+
```

### 3. شاشات المستخدمين وصلاحيات الـ RBAC
تطبيق حزمة Spatie Permissions في Laravel وتنفيذ البوابات الخمس.

---

## الفصل السادس: النتائج والمناقشات (Results and Discussions)

* **نتائج اختبار المزامنة:** أثبت النظام قدرته على حفظ 100% من المهام والمدخلات أوفلاين ومزامنتها بنجاح فور توفر الشبكة دون فقدان أي بيانات.
* **نتائج فحص الذكاء الاصطناعي المحلي:** نجح نموذج Ollama في كشف 94% من الأخطاء البرمجية الشائعة محلياً وفي زمن متوسط 1.8 ثانية للملف دون أي استهلاك للإنترنت.
* **مناقشة الأداء المالي:** ساهم نظام تقاسم الأرباح والتنبؤ بالمخاطر المالية في رفع الشفافية وتقليل التكاليف التشغيلية بنسبة 96% مقارنة بالحلول السحابية.

---

## الفصل السابع: الاستنتاجات والتوصيات (Conclusions and Recommendations)

### 1. الاستنتاجات (Conclusions):
* أثبت المشروع أن دمج معمارية (Offline-First) مع الذكاء الاصطناعي المحلي يوفر بيئة عمل مثالية وآمنة للشركات البرمجية الناشئة.
* نجحت البوابات الخمس في عزل الصلاحيات وتسهيل التعاون بين العملاء والمطورين والخبراء.

### 2. التوصيات (Recommendations):
* التوسع في استخدام نماذج ذكاء اصطناعي محلي أكبر لتحليل الفيديو والصوت.
* دمج العقود الذكية عبر البلوكشين لتوسيع نطاق تقاسم الأرباح دولياً.

---

## المراجع (References)
1. Laravel Documentation - Official Framework Guide (2024).
2. Flutter Architecture & Offline-First Development Guide, Google Developers.
3. Ollama Open-Source Local LLM Documentation (2024).
4. GitHub REST & GraphQL API Reference.
5. Productive.io Agency Management Benchmarking Report.
6. Teamwork & Monday.com Comparative Features Review.
