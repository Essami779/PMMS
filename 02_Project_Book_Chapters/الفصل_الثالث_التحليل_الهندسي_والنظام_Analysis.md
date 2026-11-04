# الفصل الثالث: التحليل الهندسي ومتطلبات النظام (Analysis)

> **مشروع التخرج:** منصة ومسرعة المشاريع التقنية والريادية المتكاملة (**TEAM Hub / PMTS**)  
> **التخصص:** نظم معلومات إدارية (MIS) & هندسة البرمجيات  
> **العام الجامعي:** 2026 / 2027م  
> **إطار العمل والتقنيات:** Laravel 12 (PHP 8.2+) | TailwindCSS | Alpine.js | PostgreSQL / SQLite | Offline-First Sync

---

## 📑 فهرس محتويات الفصل الثالث

1. [1. طرق جمع المتطلبات (Methods of Collecting Requirements)](#1-طرق-جمع-المتطلبات-methods-of-collecting-requirements)
2. [2. متطلبات العمل وقواعد الحوكمة (Work Requirements / Business Rules)](#2-متطلبات-العمل-وقواعد-الحوكمة-work-requirements--business-rules)
3. [3. متطلبات النظام الفنية (System Requirements)](#3-متطلبات-النظام-الفنية-system-requirements)
   - [أولاً: متطلبات العتاد (Hardware Requirements)](#أولا-متطلبات-العتاد-hardware-requirements)
   - [ثانياً: متطلبات البرمجيات وبيئة التشغيل (Software Requirements)](#ثانيا-متطلبات-البرمجيات-وبيئة-التشغيل-software-requirements)
4. [4. المتطلبات الوظيفية (Functional Requirements)](#4-المتطلبات-الوظيفية-functional-requirements)
5. [5. المتطلبات غير الوظيفية (Non-Functional Requirements)](#5-المتطلبات-غير-الوظيفية-non-functional-requirements)
6. [6. متطلبات المستخدمين حسب الأدوار (User Requirements)](#6-متطلبات-المستخدمين-حسب-الأدوار-user-requirements)
7. [7. تحليل المدخلات (Input Analysis)](#7-تحليل-المدخلات-input-analysis)
8. [8. تحليل المخرجات (Output Analysis)](#8-تحليل-المخرجات-output-analysis)
9. [9. مخطط تدفق البيانات (Data Flow Diagrams - DFD)](#9-مخطط-تدفق-البيانات-data-flow-diagrams---dfd)
10. [10. المخطط البيئي العام (Context Diagram - Level 0 DFD)](#10-المخطط-البيئي-العام-context-diagram---level-0-dfd)
11. [11. المخطط الصفري التفصيلي (Level-0 Process Diagram)](#11-المخطط-الصفري-التفصيلي-level-0-process-diagram)
12. [12. مخطط العلاقة البينية للكينونات (ERD - Entity Relationship Diagram)](#12-مخطط-العلاقة-البينية-للكينونات-erd---entity-relationship-diagram)
13. [13. المخطط المنطقي لقاعدة البيانات (The Logical Schema & Normalization)](#13-المخطط-المنطقي-لقاعدة-البيانات-the-logical-schema--normalization)
14. [14. المخطط الفيزيائي لقاعدة البيانات (The Physical Database Schema)](#14-المخطط-الفيزيائي-لقاعدة-البيانات-the-physical-database-schema)
15. [15. قاموس البيانات الشامل (Data Dictionary)](#15-قاموس-البيانات-الشامل-data-dictionary)
16. [16. لغة النمذجة الموحدة (UML - Unified Modeling Language)](#16-لغة-النمذجة-الموحدة-uml---unified-modeling-language)
    - [a. مخطط حالات الاستخدام (Use Case Diagram)](#a-مخطط-حالات-الاستخدام-use-case-diagram)
    - [b. مخطط الفئات والكائنات (Class Diagram)](#b-مخطط-الفئات-والكائنات-class-diagram)
    - [c. مخطط التتابع والتفاعل الزمني (Sequence Diagram)](#c-مخطط-التتابع-والتفاعل-الزمني-sequence-diagram)
    - [d. مخطط النشاط وسير العمليات (Activity Diagram)](#d-مخطط-النشاط-وسير-العمليات-activity-diagram)
    - [e. مخطط الحالة ودورة حياة الكيانات (State Machine Diagram)](#e-مخطط-الحالة-ودورة-حياة-الكيانات-state-machine-diagram)

---

## 1. طرق جمع المتطلبات (Methods of Collecting Requirements)

اعتمد فريق العمل منهجية علمية وميدانية متعددة المصادر لاستخلاص وتوثيق الاحتياجات الوظيفية والتقنية لمنظومة **TEAM Hub** لضمان تطابق الحل البرمجي مع واقع العمل الفعلي لأصحاب المصلحة:

### 1.1 المقابلات الشخصية الميدانية والموجّهة (Interviews)

عُقدت سلسلة من المقابلات المعمقة (شبه الموجهة Semi-Structured Interviews) مع الفئات المستهدفة:

- **الأكاديميون ومستشارو المشاريع (12 أستاذاً ومحكّماً):** للتعرف على المشاكل التي تواجههم في تقييم مخرجات الطلاب ومتابعة الـ Commits وتحديد مواعيد الاستشارات.
- **قادة ومطورو الفرق التقنية (25 طالباً ومطوراً):** لمناقشة عوائق توزيع المهام، ومشاكل استكمال الأعضاء ذوي التخصصات النادرة، وصعوبة حفظ الإصدارات والوثائق.
- **ممثلو قطاع الأعمال ومسؤولو التوظيف بالشركات البرمجية (8 شركات):** لتحديد معايير استقطاب النخب الطلابية، وكيفية طرح التحديات التجارية والرعاية المالية.

### 1.2 الاستبيان الإلكتروني المسحي (Questionnaires)

تم تصميم وتوزيع استبيان إحصائي موجّه لمجتمع كليات الحاسوب والشركات الناشئة؛ حيث تم جمع وتحليل **184 استجابة مكتملة**. وقد أظهرت النتائج:

- **89.2%** يعانون من تشتت الأدوات (استخدام Trello لمهام العمل، WhatsApp للمحادثات، Google Drive للوثائق، وZoom للاجتماعات).
- **78.4%** أكدوا انقطاع وتأخر التواصل مع المستشارين المشرفين لعدم وجود جدول مواعيد رسمي موثق.
- **93.5%** من الشركات أبدت رغبة ملحة في وجود منصة موحدة تستعرض المشاريع الجاهزة والمصنفة حسب قطاع الأعمال (FinTech, AI, HealthTech).

### 1.3 الملاحظة المباشرة ودراسة بيئة العمل الواقعية (Observation)

قام فريق التحليل بمراقبة جلسات المناقشة والتحكيم السنوية للمشاريع الجامعية وحضور فعاليات هاكاثونات تقنية؛ وتم تدوين الملاحظات حول:

- غياب التوثيق الفوري لتوصيات اللجان؛ مما يؤدي لفقدان الملاحظات البرمجية.
- الصعوبة في استعراض السير الذاتية (CVs) للمشاركين أثناء تقييم مشاريعهم.

### 1.4 فحص وتدقيق الوثائق والنماذج القائمة (Document Review)

تم جمع وفحص النماذج المعتمدة في إدارة المشاريع:

- نماذج مواصفات متطلبات البرمجيات المعتمدة (IEEE 830 SRS Templates).
- استمارات تحكيم وتقييم مشاريع التخرج الأكاديمية.
- عقود واتفاقيات رعاية المشاريع والمسؤولية المجتمعية (CSR).

---

## 2. متطلبات العمل وقواعد الحوكمة (Work Requirements / Business Rules)

تحدد قواعد العمل المنطق المؤسسي والتنظيمي (**Business Logic Rules - BR**) الذي يحكم جميع العمليات التفاعلية داخل النظام:

- **[BR-01] حوكمة تسجيل الفرق وقادتها:** لا يحق للمستخدم إنشاء أكثر من فريق نشط واحد كـ "قائد فريق" (Team Leader)، بينما يمكنه الانضمام كعضو في فرق أخرى شريطة قبول الدعوة الرسمية.
- **[BR-02] كود الانضمام السري وتأمين التشكيلة:** لكل فريق برمجية رمز سري فريد (Invite Code) مكوّن من 12 خانة عشوائية، لا يمكن لأي عضو الانضمام إلا عبر إدخال هذا الرمز أو عبر رابط دعوة مشفر مؤقت الصلاحية (7 أيام).
- **[BR-03] آلية احتساب نسبة إنجاز المشروع التلقائية:** تحسب نسبة التقدم المئوية للمشروع تلقائياً استناداً إلى معادلة أوزان المهام المكتملة في لوحة الكانبان:
  $$\text{Progress \%} = \left( \frac{\sum \text{Completed Tasks}}{\text{Total Tasks}} \times 0.6 \right) + \left( \frac{\text{Approved Documents}}{5} \times 0.4 \right) \times 100$$
- **[BR-04] تصنيف مهام الكانبان ودورة حياتها:** تمر أي مهمة برمجية بإلزامية الترتيب التسلسلي عبر أربع حالات: `Todo` -> `In Progress` -> `Review` -> `Done`، ولا يمكن نقل المهمة لحالة المكتملة إلا بعد تسجيل تاريخ الإنجاز وتحديد المطور المسؤول.
- **[BR-05] قواعد خزانة وثائق المشروع (Vault):** تخضع الملفات المرفوعة إلى تصنيف إلزامي (`Technical`, `Architecture`, `Pitch Deck`, `Reports`, `Agreements`) مع إلزامية وضع رقم الإصدار (Version Tagging) وحد أقصى لحجم الملف (15MB).
- **[BR-06] حوكمة الجلسات الاستشارية:** لا تكتمل الجلسة الاستشارية في سجل المشروع إلا بعد قيام الخبير بكتابة **التوصيات الفنية الرسمية**، وإدخال الفريق لتقييم الجلسة بالنجوم (1 إلى 5 نجوم).
- **[BR-07] قواعد الرعاية وحوكمة الشركات (Deal Flow):** لا يمكن للشركات الاطلاع على الشيفرة المصدرية المباشرة (Private Repositories) إلا بعد تقديم طلب رعاية رسمي وموافقة قائد الفريق الأكاديمي.

---

## 3. متطلبات النظام الفنية (System Requirements)

### أولاً: متطلبات العتاد (Hardware Requirements)

#### 1. متطلبات الخادم المركزي (Production Server Environment)

- **المعالج (CPU):** رباعي النوى بسرعة 2.5 GHz كحد أدنى (Quad-Core x86-64 / ARM64).
- **الذاكرة العشوائية (RAM):** 8 GB كحد أدنى (يوصى بـ 16 GB لتمكين نماذج الذكاء الاصطناعي المحلية ومعالجة التصدير).
- **سعة التخزين (Disk Storage):** 80 GB SSD NVMe لسرعة معالجة استعلامات قواعد البيانات والملفات المرفوعة.
- **الشبكة:** اتصال إنترنت عريض النطاق بسرعة رفع/تنزيل لا تقل عن 100 Mbps مع عنوان IP ثابت.

#### 2. متطلبات محطات عمل المستخدمين (Client Workstations & Devices)

- **أجهزة الحاسوب:** معالج ثنائي النواة 1.8 GHz، ذاكرة 4 GB RAM، دقة شاشة $1280 \times 720$ فما فوق.
- **الهواتف الذكية والأجهزة اللوحية:** أنظمة Android 10+ أو iOS 14+، ذاكرة 3 GB RAM.

### ثانياً: متطلبات البرمجيات وبيئة التشغيل (Software Requirements)

- **خادم الويب (Web Server):** Nginx 1.24+ أو Apache 2.4+ مع دعم بروتوكول HTTP/2 وSSL/TLS.
- **بيئة التشغيل والخلفية (Backend Stack):**
  - لغة البرمجة: PHP 8.2+ أو PHP 8.3 مع ملحقات (`pdo_pgsql`, `mbstring`, `bcmath`, `curl`, `intl`, `gd`).
  - إطار العمل الأساسي: **Laravel 12.x**.
- **نظام إدارة قواعد البيانات (DBMS):**
  - السيرفر المركزي: **PostgreSQL 16+** (أو MySQL 8.0+).
  - التخزين والمزامنة بدون اتصال (Offline Engine): **SQLite 3.4+ / IndexedDB**.
- **الواجهات الأمامية والمكتبات (Frontend Stack):**
  - معمارية التصميم: **TailwindCSS 3.4+ / Vite 7.x**.
  - التفاعل الحي: **Alpine.js 3.x** و **Blade Component Engine**.
- **المتصفحات المتوافقة:** Google Chrome 110+, Mozilla Firefox 115+, Microsoft Edge 110+, Apple Safari 16+.

---

## 4. المتطلبات الوظيفية (Functional Requirements)

تم ترقيم وصياغة المتطلبات الوظيفية وفقاً للمعيار الدولي بصيغة _"يجب على النظام أن يوفر..."_:

### 4.1 وحدة إدارة الهوية والمصادقة والصلاحيات (Auth & RBAC)

- **[FR-01]:** يجب أن يتيح النظام تسجيل حسابات جديدة وتصنيفها فورياً وفق المسارات الثلاثة: (فريق/مطور، شركة/شريك راعٍ، مستشار/خبير).
- **[FR-02]:** يجب توفير مصادقة آمنة عبر تشفير كلمات المرور باستخدام خوارزمية **Bcrypt / Argon2id** مع ميزة "تذكرني" وحماية من هجمات التخمين (Rate Limiting).
- **[FR-03]:** يجب تطبيق نظام صلاحيات وأدوار ديناميكي (Spatie RBAC) يفصل صلاحيات مدير النظام، وقائد الفريق، وعضو الفريق، والمستشار، وممثل الشركة.

### 4.2 وحدة إدارة مساحة عمل الفرق والمشاريع (Team Workspace & Core)

- **[FR-04]:** يجب أن يتيح النظام لقائد الفريق إنشاء ملف المشروع، وتحديد العنوان، والوصف، والتصنيف البرمجي، والجامعة، والربط بمستودع GitHub.
- **[FR-05]:** يجب توليد كود انضمام عشوائي فريد لكل فريق (Invite Code)، مع إمكانية إرسال دعوات عبر البريد الإلكتروني مع روابط مؤقتة.
- **[FR-06]:** يجب استعراض تشكيلة الفريق وتحديد المهارات الناقصة وفتح باب الاستقطاب للمطورين الآخرين.

### 4.3 وحدة لوحة مهام الكانبان الرشيقة (Agile Kanban Board)

- **[FR-07]:** يجب توفير لوحة مهام تفاعلية مقسمة إلى أربعة أعمدة (`Todo`, `In Progress`, `Review`, `Done`).
- **[FR-08]:** يجب تمكين إسناد المهمة لعضو محدد، وتعيين درجة الأولوية (`Urgent`, `High`, `Medium`, `Low`)، وتاريخ الاستحقاق (Due Date).
- **[FR-09]:** يجب تحديث النسبة المئوية لإنجاز المشروع كلياً فور تحريك المهام إلى عمود الإنجاز.

### 4.4 وحدة السير الذاتية وملفات الأعضاء (CV Drawer & Talent Hub)

- **[FR-10]:** يجب تمكين كل عضو من إدخال ملفه المهني، وسنوات الخبرة، والمعدل، والمهارات التقنية، وروابط حساباته على GitHub و LinkedIn.
- **[FR-11]:** يجب توفير قارئ سيرة ذاتية تفاعلي (PDF Live Viewer) مدمج يتيح فحص الـ CV داخل المنصة دون الحاجة لتنزيله.
- **[FR-12]:** يجب توفير زر اتصال فوري يفتح محادثة واتساب مشفرة مباشرة مع العضو/المرشح.

### 4.5 وحدة خزانة الوثائق والمخرجات (Project Document Vault)

- **[FR-13]:** يجب توفير مستودع سحابي سليم لتخزين وثائق المشروع وتصنيفها إلى (متطلبات SRS، مخططات معمارية، عروض Pitch Decks، وتقارير QA).
- **[FR-14]:** يجب تتبع إصدارات الوثائق وتوثيق هوية رافع الملف، وتاريخ الرفع، وحجم الملف، ونوعه.

### 4.6 وحدة غرفة العمليات والنقاشات المعمارية (War Room & ADRs)

- **[FR-15]:** يجب توفير مساحة نقاشات داخلية آمنة تتيح توثيق القرارات المعمارية (Architectural Decision Records - ADRs).
- **[FR-16]:** يجب دعم التنبيه الفوري بالعوائق البرمجية الحرجة (Blockers)، وإمكانية تثبيت الإعلانات الإدارية الهامة (Pinned Announcements).
- **[FR-17]:** يجب تمكين الأعضاء من كتابة ردود تفاعلية متسلسلة على مواضيع النقاش.

### 4.7 وحدة استشارات الخبراء والتحكيم (Advisory & Mentorship)

- **[FR-18]:** يجب تمكين الفرق من تصفح دليل المستشارين المعتمدين وتقديم طلب حجز جلسة استشارية متخصصة.
- **[FR-19]:** يجب أن يتيح النظام للمستشار قبول الموعد وتوليد رابط الاجتماع الافتراضي (Google Meet) وتوثيق التوصيات الفنية في سجل الفريق.
- **[FR-20]:** يجب توفير سجل تراكمي للمستشار يحسب إجمالي ساعات الإرشاد والفرق التي تم تحكيمها.

### 4.8 وحدة رعاية الشركات والاستثمار (Enterprise Deal Flow)

- **[FR-21]:** يجب توفير دليل مصنف للمشاريع الجاهزة والمفتوحة للرعاية يتيح للشركات استكشاف الحلول حسب القطاع ونسبة الإنجاز.
- **[FR-22]:** يجب تمكين الشركات من طرح تحديات برمجية رسمية مع تحديد الجوائز، واستقبال حلول الفرق المنافسة.

### 4.9 وحدة التقارير التنفيذية والتصدير (Executive Reports & Print Engine)

- **[FR-23]:** يجب توليد تقرير رسمي وشامل للمشروع قابل للطباعة بصيغة PDF يتضمن مصفوفة الإنجاز، هيكل الفريق، الوثائق، وتوصيات المستشارين.

---

## 5. المتطلبات غير الوظيفية (Non-Functional Requirements)

| المعيار                                 | متطلب الجودة                                | معيار القياس والتحقق                                                                                                                                   |
| --------------------------------------- | ------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **الأداء والسرعة (Performance)**        | سرعة استجابة الخادم وتوليد الصفحات          | ألا يتجاوز زمن الاستجابة (Server Response Time) **800ms** تحت الحمل الطبيعي، وزمن استعلام قاعدة البيانات أقل من **50ms**.                              |
| **الأمان والتحصين (Security)**          | حماية البيانات، تشفير الاتصال، ومنع الثغرات | تشفير HTTPS/TLS إلزامي، حماية كاملة من ثغرات **OWASP Top 10** (CSRF Protection, SQL Injection via Eloquent, XSS Escaping, Password Hashing).           |
| **الموثوقية والجاهزية (Reliability)**   | استمرارية الخدمة والتعافي من الأعطال        | جاهزية المنظومة بمعدل **99.5% Uptime**، مع نظام نسخ احتياطي يومي آلي لقاعدة البيانات وتخزين سحابي للوثائق.                                             |
| **الاستمرارية (Offline-First)**         | القدرة على العمل عند انقطاع الإنترنت        | حفظ بيانات الكانبان والمهام محلياً في المتصفح، ومزامنة التعديلات تلقائياً مع السيرفر فور استعادة الاتصال.                                              |
| **سهولة الاستخدام (Usability)**         | واجهات مستخدم مريحة ومفهومة                 | واجهة متوافقة مع مبادئ التصميم الحديثة، تدعم التبديل السلس بين الوضعين (الليلي Dark Mode والنهاري Light Mode)، وخطوط عربية واضحة (Cairo & Readex Pro). |
| **التوافقية والانتشار (Compatibility)** | استجابة الواجهات على كافة الأجهزة           | تصميم متجاوب كلياً (Fully Responsive) يغطي شاشات الهواتف ($360\text{px}$)، الأجهزة اللوحية ($768\text{px}$)، والشاشات العريضة ($1920\text{px}$).       |
| **قابلية التوسع (Scalability)**         | استيعاب زيادة البيانات والمستخدمين          | بنية برمجية معيارية (Modular Architecture) تدعم إضافة بوابات وكيانات جديدة وملايين السجلات دون التأثير على استقرار النظام.                             |

---

## 6. متطلبات المستخدمين حسب الأدوار (User Requirements)

```mermaid
flowchart TD
    subgraph Users["أصحاب المصلحة ومستخدمو المنظومة"]
        direction TB
        L["قائد الفريق<br/>(Team Leader)"]
        M["عضو الفريق / المطور<br/>(Developer / Member)"]
        C["المستشار / المحكّم<br/>(Advisor / Juror)"]
        E["شريك الأعمال / الشركة<br/>(Enterprise Sponsor)"]
        A["مدير المنظومة<br/>(System Admin)"]
    end

    subgraph Actions["المهام والمتطلبات الأساسية لكل مستخدم"]
        direction TB
        L -->|يدير| L_Act["تأسيس الفريق، إسناد مهام الكانبان، دعوة الأعضاء، رفع الوثائق، وتصدير التقرير"]
        M -->|ينفذ| M_Act["تحديث حالة المهام، رفع السيرة الذاتية، المشاركة بغرفة العمليات، وتدوين الوقفات اليومية"]
        C -->|يوجّه| C_Act["ضبط المواعيد، تقديم جلسات الإرشاد، فحص كود ومعمارية المشروع، واعتماد التوصيات"]
        E -->|يستثمر| E_Act["تصفح المشاريع المصنفة، طرح التحديات، استقطاب النخب، وتقديم عروض الرعاية"]
        A -->|يراقب| A_Act["مراقبة السجلات الأمنية، إدارة الحسابات، ضبط العملات والثوابت، وإدارة النسخ الاحتياطية"]
    end

    style Users fill:#f8fafc,stroke:#64748b,stroke-width:2px;
    style Actions fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
```

---

## 7. تحليل المدخلات (Input Analysis)

يوضح الجدول التالي تحليلاً شاملاً لحقول وبيانات المدخلات وقواعد التحقق البرمجية (Validation Rules):

| الشاشة / الوحدة        | مصدر المدخل     | الحقول وبيانات الإدخال                                      | نوع البيانات  | قيود وشروط التحقق (Validation Rules) |
| ---------------------- | --------------- | ----------------------------------------------------------- | :-----------: | ------------------------------------ | --------------------------------- | ------------------------- | ------------ | ------------ |
| **تسجيل الحساب**       | المستخدم الزائر | الاسم الكامل، البريد، كلمة المرور، المسار                   |     نصوص      | `required                            | string                            | email                     | unique:users | min:8`       |
| **تأسيس الفريق**       | قائد الفريق     | اسم الفريق، عنوان المشروع، النطاق، القسم، مستودع GitHub     |  نصوص وروابط  | `required                            | max:255                           | url                       | nullable`    |
| **إضافة مهمة كانبان**  | قائد الفريق     | عنوان المهمة، الوصف، المطور المعين، الأولوية، تاريخ الإنجاز | نصوص وتواريخ  | `required                            | string                            | in:urgent,high,medium,low | date`        |
| **ملف السيرة الذاتية** | المطور / العضو  | التخصص، الهاتف، المهارات، الروابط، ملف الـ CV               | نصوص وملف PDF | `nullable                            | file                              | mimes:pdf                 | max:10240`   |
| **رفع وثيقة بالخزانة** | عضو الفريق      | عنوان الوثيقة، التصنيف، ملف الوثيقة، رقم الإصدار            |   نصوص وملف   | `required                            | in:technical,architecture,reports | max:15360`                |
| **حجز استشارة**        | قائد الفريق     | اسم المستشار، الموضوع، التصنيف، الوصف، التاريخ المقترح      |  نصوص وتاريخ  | `required                            | string                            | date                      | after:today` |
| **توثيق التوصيات**     | المستشار        | نص التوصيات، تقييم الجاهزية، رابط الاجتماع                  |  نصوص وروابط  | `required                            | string                            | url                       | nullable`    |
| **طرح تحدٍ برمجـي**    | الشركة الراعية  | عنوان التحدي، الوصف، قيمة الجائزة، الموعد النهائي           |  نصوص وأرقام  | `required                            | numeric                           | min:100                   | date         | after:today` |

---

## 8. تحليل المخرجات (Output Analysis)

| الشاشة / التقرير             |     صيغة المخرج     | المستفيد النهائي                | توقيت ودورية الصدور       | المحتوى والمعلومات المعروضة                                                       |
| ---------------------------- | :-----------------: | ------------------------------- | ------------------------- | --------------------------------------------------------------------------------- |
| **لوحة قيادة المشروع**       |    شاشة تفاعلية     | أعضاء الفريق والقائد            | لحظي (Real-time)          | نسبة الإنجاز العامة، عدد المهام المكتملة، مواعيد الجلسات القادمة، وآخر التحديثات. |
| **التقرير التنفيذي الشامل**  |  مستند PDF / طباعة  | قائد الفريق، الكلية، المستثمرون | عند الطلب / نهاية المرحلة | بيانات المشروع، مصفوفة المهام، تشكيلة الفريق بخبراتهم، وسجل توصيات المستشارين.    |
| **درج استعراض الـ CV**       |   عارض PDF تفاعلي   | قائد الفريق، الشركات            | فوري عند النقر            | استعراض السيرة الذاتية للأعضاء دون تنزيل، مع روابط الأعمال وزر الواتساب.          |
| **دليل المشاريع الاستثماري** |   شاشات ويب وبحث    | الشركات ورعاة الأعمال           | متاح دائماً               | قائمة المشاريع المصنفة، نسب الإنجاز، مجالات الابتكار، وإمكانية تقديم طلب رعاية.   |
| **سجل الأثر الاستشاري**      |  صفحة ويب / شهادة   | المستشار والأستاذ               | تراكمي مستمر              | عدد ساعات الإرشاد الموثقة، تقييمات الفرق، وقائمة الهاكاثونات المحكّمة.            |
| **إشعارات وتنبيهات النظام**  | Toast / صوتي / بريد | كافة المستخدمين                 | فوري عند الحدث            | إشعار بتعيين مهمة جديدة، تأكيد موعد جلسة، أو انضمام عضو جديد للفريق.              |

---

## 9. مخطط تدفق البيانات (Data Flow Diagrams - DFD)

تُعد مخططات تدفق البيانات الأداة الهندسية المعتمدة لنمذجة حركة البيانات بين الكيانات الخارجية للنظام، والعمليات الحسابية والبرمجية، ومخازن البيانات الدائمة:

- **المخطط البيئي (Context Diagram / Level 0):** ينظر للنظام كعملية واحدة شاملة ترتبط بالكيانات المحيطة دون كشف التركيب الداخلي.
- **المخطط الصفري (Level-0 Process Diagram):** يفكك النظام إلى عملياته التفصيلية الست مع ربطها بمخازن البيانات المحددة.

---

## 10. المخطط البيئي العام (Context Diagram - Level 0 DFD)

```mermaid
flowchart TD
    %% Entities
    Leader["قائد الفريق البرمجي<br/>(Team Leader)"]
    Member["عضو الفريق / المطور<br/>(Team Member)"]
    Consultant["المستشار / المحكّم<br/>(Advisor / Juror)"]
    Company["الشركة / الشريك الراعي<br/>(Enterprise Sponsor)"]
    Admin["إدارة المنظومة الأكاديمية<br/>(System Admin)"]

    %% Core System
    System(("0.0<br/>منظومة إدارة ومتابعة المشاريع<br/>TEAM Hub Platform"))

    %% Data Flows
    Leader -->|"بيانات المشروع، توزيع المهام، طلبات الاستشارة، الوثائق"| System
    System -->|"نسب الإنجاز، التقرير التنفيذي، تأكيد المواعيد، الإشعارات"| Leader

    Member -->|"تحديثات المهام، رفع السيرة الذاتية، منشورات غرفة العمليات"| System
    System -->|"قوائم المهام المسندة، تنبيهات الـ Blockers، بيانات الفريق"| Member

    Consultant -->|"جدول التوفر، التوصيات المعمارية، درجات التحكيم"| System
    System -->|"طلبات الإرشاد، وثائق المشروع، روابط الاجتماعات"| Consultant

    Company -->|"عروض الرعاية، التحديات التقنية، معايير التوظيف"| System
    System -->|"دليل المشاريع الجاهزة، قوائم المطورين، تقارير الشفافية"| Company

    Admin -->|"إدارة المستخدمين، ضبط الصلاحيات، التحكم بالثوابت"| System
    System -->|"سجلات النشاط (Audit Logs)، إحصائيات النظام الشاملة"| Admin

    style System fill:#4f46e5,stroke:#3730a3,stroke-width:3px,color:#ffffff;
    style Leader fill:#e0e7ff,stroke:#6366f1,stroke-width:2px;
    style Member fill:#f1f5f9,stroke:#64748b,stroke-width:2px;
    style Consultant fill:#dcfce7,stroke:#16a34a,stroke-width:2px;
    style Company fill:#fef3c7,stroke:#d97706,stroke-width:2px;
    style Admin fill:#ffe4e6,stroke:#e11d48,stroke-width:2px;
```

---

## 11. المخطط الصفري التفصيلي (Level-0 Process Diagram)

```mermaid
flowchart TD
    %% Entities
    U["المستخدم / المطور"]
    L["قائد الفريق"]
    C["المستشار"]
    E["الشركة الراعية"]

    %% Processes
    P1(("1.0<br/>المصادقة وإدارة الهوية<br/>(Auth & Profile)"))
    P2(("2.0<br/>إدارة الفريق والمشروع<br/>(Team Workspace)"))
    P3(("3.0<br/>إدارة مهام الكانبان<br/>(Kanban Tasks)"))
    P4(("4.0<br/>خزانة الوثائق والملفات<br/>(Document Vault)"))
    P5(("5.0<br/>غرفة العمليات والنقاش<br/>(War Room Discussions)"))
    P6(("6.0<br/>الاستشارات والتحكيم<br/>(Advisory & Sessions)"))
    P7(("7.0<br/>الاستثمار والرعاية<br/>(Deal Flow & Sponsor)"))

    %% Data Stores
    D1[("D1: جدول المستخدمين (users)")]
    D2[("D2: جدول الفرق (teams & members)")]
    D3[("D3: جدول المهام (team_tasks)")]
    D4[("D4: جدول الوثائق (team_documents)")]
    D5[("D5: جدول النقاشات (team_discussions)")]
    D6[("D6: جدول الاستشارات (team_consultations)")]

    %% Flows
    U -->|"تسجيل الدخول / الملف المهني"| P1
    P1 <-->|"قراءة والتحقق من الحسابات"| D1

    L -->|"تأسيس الفريق والربط بـ GitHub"| P2
    P2 <-->|"حفظ واسترجاع بيانات الفرق"| D2

    L & U -->|"إنشاء وتحديث حالة المهام"| P3
    P3 <-->|"حفظ تفاصيل المهام والأولويات"| D3
    P3 -.->|"تحديث نسبة الإنجاز تلقائياً"| P2

    U -->|"رفع ملفات الـ SRS والمعمارية"| P4
    P4 <-->|"فهرسة وحفظ الوثائق"| D4

    U -->|"تدوين القرارات والـ Blockers"| P5
    P5 <-->|"حفظ النقاشات والردود"| D5

    L -->|"طلب استشارة تقنية"| P6
    C -->|"توثيق التوصيات والاعتماد"| P6
    P6 <-->|"جدولة وتوثيق الجلسات"| D6

    E -->|"استكشاف المشاريع وتقديم الرعاية"| P7
    P7 <-->|"قراءة بيانات المشاريع المكتملة"| D2

    style P1 fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
    style P2 fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
    style P3 fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
    style P4 fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
    style P5 fill:#eef2ff,stroke:#6366f1,stroke-width:2px;
    style P6 fill:#dcfce7,stroke:#16a34a,stroke-width:2px;
    style P7 fill:#fef3c7,stroke:#d97706,stroke-width:2px;

    style D1 fill:#f8fafc,stroke:#475569,stroke-width:2px;
    style D2 fill:#f8fafc,stroke:#475569,stroke-width:2px;
    style D3 fill:#f8fafc,stroke:#475569,stroke-width:2px;
    style D4 fill:#f8fafc,stroke:#475569,stroke-width:2px;
    style D5 fill:#f8fafc,stroke:#475569,stroke-width:2px;
    style D6 fill:#f8fafc,stroke:#475569,stroke-width:2px;
```

---

## 12. مخطط العلاقة البينية للكينونات (ERD - Entity Relationship Diagram)

يوضح هذا المخطط البنية العلائقية لقاعدة البيانات، وروابط الكينونات الأساسية والمفاتيح الأولية والأجنبية:

```mermaid
erDiagram
    USERS ||--o{ TEAMS : "leads"
    USERS ||--o{ TEAM_MEMBERS : "participates_in"
    USERS ||--o| MEMBER_PROFILES : "owns"
    USERS ||--o{ TEAM_TASKS : "assigned_to"
    USERS ||--o{ TEAM_DOCUMENTS : "uploads"
    USERS ||--o{ TEAM_CONSULTATIONS : "requests"
    USERS ||--o{ TEAM_DISCUSSIONS : "creates"
    USERS ||--o{ TEAM_DISCUSSION_REPLIES : "replies"

    TEAMS ||--|{ TEAM_MEMBERS : "contains"
    TEAMS ||--o{ TEAM_INVITATIONS : "issues"
    TEAMS ||--o{ TEAM_TASKS : "owns"
    TEAMS ||--o{ TEAM_DOCUMENTS : "stores"
    TEAMS ||--o{ TEAM_STANDUPS : "records"
    TEAMS ||--o{ TEAM_CONSULTATIONS : "holds"
    TEAMS ||--o{ TEAM_DISCUSSIONS : "discusses"

    TEAM_DISCUSSIONS ||--o{ TEAM_DISCUSSION_REPLIES : "includes"

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string avatar
        timestamp email_verified_at
        timestamps created_at
    }

    TEAMS {
        bigint id PK
        bigint leader_id FK
        string name
        string project_title
        text description
        string category
        string university
        string department
        string invite_code UK
        string status
        tinyint progress_percentage
        string github_repo
        timestamps created_at
    }

    TEAM_MEMBERS {
        bigint id PK
        bigint team_id FK
        bigint user_id FK
        string role_in_team
        string status
        timestamp joined_at
    }

    MEMBER_PROFILES {
        bigint id PK
        bigint user_id FK,UK
        string job_title
        string phone
        text skills
        string major
        decimal gpa
        string github_url
        string linkedin_url
        string cv_path
    }

    TEAM_TASKS {
        bigint id PK
        bigint team_id FK
        bigint assigned_to FK
        string title
        text description
        string status
        string priority
        date due_date
        timestamps created_at
    }

    TEAM_DOCUMENTS {
        bigint id PK
        bigint team_id FK
        bigint uploaded_by FK
        string title
        string category
        string file_path
        string file_name
        bigint file_size
        string file_type
        string version
        timestamps created_at
    }

    TEAM_CONSULTATIONS {
        bigint id PK
        bigint team_id FK
        bigint requested_by FK
        string consultant_name
        string topic
        string category
        string status
        datetime session_date
        string meeting_link
        text recommendations
        tinyint rating
        timestamps created_at
    }

    TEAM_DISCUSSIONS {
        bigint id PK
        bigint team_id FK
        bigint user_id FK
        string title
        text content
        string category
        boolean is_pinned
        uint replies_count
        timestamps created_at
    }

    TEAM_DISCUSSION_REPLIES {
        bigint id PK
        bigint discussion_id FK
        bigint user_id FK
        text content
        timestamps created_at
    }

    TEAM_STANDUPS {
        bigint id PK
        bigint team_id FK
        bigint user_id FK
        text content
        string type
        timestamps created_at
    }

    TEAM_INVITATIONS {
        bigint id PK
        bigint team_id FK
        bigint invited_by FK
        string email
        string role_in_team
        string token UK
        string status
        timestamp expires_at
    }
```

---

## 13. المخطط المنطقي لقاعدة البيانات (The Logical Schema & Normalization)

خضعت قاعدة بيانات المنظومة لمراحل التسوية والتطبيع الثلاث (**Database Normalization Rules**):

- **الشكل الطبيعي الأول (1NF):** منع الحقول متعددة القيم وتأكيد ذرية البيانات (Atomicity)، والتأكد من وجود مفتاح أساسي فريد لكل جدول.
- **الشكل الطبيعي الثاني (2NF):** إزالة أي اعتمادية جزئية؛ فكافة الحقول غير المفتاحية تعتمد اعتماداً كلياً ومباشراً على المفتاح الأساسي.
- **الشكل الطبيعي الثالث (3NF):** إزالة الاعتماديات المتعدية (Transitive Dependencies)؛ بحيث لا يعتمد أي حقل غير رئيسي على حقل آخر غير رئيسي، بل على المفتاح الأساسي فقط.
- **تفكيك العلاقات المتعددة ($M:N$):** تم تفكيك العلاقة بين المستخدمين (`users`) والفرق (`teams`) عبر جدول الربط الوسيط (`team_members`) الذي يحمل المفاتيح الأجنبية (`team_id`, `user_id`) إضافة للسمات الوظيفية (`role_in_team`, `joined_at`).

### التوصيف العلائقي للجداول (Relational Schema Notation):

- $\text{USERS} (\underline{\text{id}}, \text{name}, \text{email}, \text{password}, \text{avatar}, \text{email\_verified\_at}, \text{created\_at})$
- $\text{TEAMS} (\underline{\text{id}}, \text{name}, \text{project\_title}, \text{description}, \text{category}, \text{university}, \text{invite\_code}, \text{status}, \text{progress\_percentage}, \text{github\_repo}, \overline{\text{leader\_id}})$
- $\text{TEAM\_MEMBERS} (\underline{\text{id}}, \overline{\text{team\_id}}, \overline{\text{user\_id}}, \text{role\_in\_team}, \text{status}, \text{joined\_at})$
- $\text{MEMBER\_PROFILES} (\underline{\text{id}}, \overline{\text{user\_id}}, \text{job\_title}, \text{phone}, \text{skills}, \text{major}, \text{gpa}, \text{cv\_path}, \text{github\_url}, \text{linkedin\_url})$
- $\text{TEAM\_TASKS} (\underline{\text{id}}, \overline{\text{team\_id}}, \overline{\text{assigned\_to}}, \text{title}, \text{description}, \text{status}, \text{priority}, \text{due\_date})$
- $\text{TEAM\_DOCUMENTS} (\underline{\text{id}}, \overline{\text{team\_id}}, \overline{\text{uploaded\_by}}, \text{title}, \text{category}, \text{file\_path}, \text{file\_size}, \text{version})$
- $\text{TEAM\_CONSULTATIONS} (\underline{\text{id}}, \overline{\text{team\_id}}, \overline{\text{requested\_by}}, \text{consultant\_name}, \text{topic}, \text{status}, \text{session\_date}, \text{recommendations}, \text{rating})$
- $\text{TEAM\_DISCUSSIONS} (\underline{\text{id}}, \overline{\text{team\_id}}, \overline{\text{user\_id}}, \text{title}, \text{content}, \text{category}, \text{is\_pinned}, \text{replies\_count})$

---

## 14. المخطط الفيزيائي لقاعدة البيانات (The Physical Database Schema)

يعكس المخطط الفيزيائي كيفية تخزين البيانات فعلياً على محرك **PostgreSQL / SQLite** مع تحديد أطوال الحقول والفهارس وقواعد التكامل المرجعي:

- **المحرك والمطابقة:** `InnoDB` على MySQL أو `PostgreSQL 16` مع تشفير وتوافق كامل لترميز النصوص `utf8mb4_unicode_ci`.
- **الفهارس والتسريع (Indexing Strategy):**
  - فهارس فريدة (Unique Indexes) على: `users(email)`، `teams(invite_code)`، `member_profiles(user_id)`، و `team_invitations(token)`.
  - فهرس مركب (Composite Index) على: `team_members(team_id, user_id)`.
  - فهارس بحث سريعة (Foreign Key Indexes) على: `team_tasks(team_id, status)` لتسريع استعلامات لوحة الكانبان.
- **سلامة المراجع والحذف المتسلسل (Referential Integrity):**
  - جميع الجداول التابعة للفريق تستخدم قاعدة `ON DELETE CASCADE`؛ بحيث يؤدي حذف الفريق تلقائياً إلى تنظيف مهامه ومستنداته ونقاشاته لتجنب البيانات اليتيمة (Orphan Records).
  - حقل `assigned_to` في جدول المهام يستخدم `ON DELETE SET NULL` للحفاظ على بيانات المهمة حتى في حال مغادرة المطور للفريق.

---

## 15. قاموس البيانات الشامل (Data Dictionary)

### 15.1 جدول الفرق والمشاريع (`teams`)

| اسم الحقل             | نوع البيانات     | الطول/السعة | القيود (Constraints)                       |         القيمة الافتراضية         | الوصف التفصيلي                                        |
| --------------------- | ---------------- | :---------: | ------------------------------------------ | :-------------------------------: | ----------------------------------------------------- |
| `id`                  | BIGINT UNSIGNED  |     20      | PRIMARY KEY, AUTO_INCREMENT                |                 -                 | المعرّف الرقمي الفريد للفريق                          |
| `leader_id`           | BIGINT UNSIGNED  |     20      | FOREIGN KEY (`users.id`) ON DELETE CASCADE |                 -                 | معرّف قائد ومؤسس الفريق                               |
| `name`                | VARCHAR          |     255     | NOT NULL                                   |                 -                 | الاسم الرسمي لفريق العمل                              |
| `project_title`       | VARCHAR          |     255     | NOT NULL                                   |                 -                 | العنوان الأكاديمي أو التجاري للمشروع                  |
| `description`         | TEXT             |      -      | NULLABLE                                   |               NULL                | نبذة تعريفية وشرح نطاق المشروع                        |
| `category`            | VARCHAR          |     150     | NULLABLE                                   | 'الذكاء الاصطناعي وتطبيقات الويب' | قطاع العمل والتخصص البرمجي                            |
| `university`          | VARCHAR          |     150     | NULLABLE                                   |           'جامعة صنعاء'           | اسم الجامعة أو المؤسسة التابع لها                     |
| `department`          | VARCHAR          |     150     | NULLABLE                                   |          'كلية الحاسوب'           | الكلية أو القسم الأكاديمي                             |
| `invite_code`         | VARCHAR          |     12      | UNIQUE, NOT NULL                           |                 -                 | رمز الانضمام السري المؤقت للفريق                      |
| `status`              | VARCHAR          |     50      | NOT NULL                                   |           'in_progress'           | حالة المشروع (`ideation`, `in_progress`, `completed`) |
| `progress_percentage` | TINYINT UNSIGNED |      3      | NOT NULL                                   |                25                 | النسبة المئوية المحسوبة آلياً لتقدم المشروع           |
| `github_repo`         | VARCHAR          |     255     | NULLABLE                                   |               NULL                | رابط مستودع المشروع على GitHub                        |

### 15.2 جدول مهام الكانبان (`team_tasks`)

| اسم الحقل     | نوع البيانات    | الطول/السعة | القيود (Constraints)                        | القيمة الافتراضية | الوصف التفصيلي                                          |
| ------------- | --------------- | :---------: | ------------------------------------------- | :---------------: | ------------------------------------------------------- |
| `id`          | BIGINT UNSIGNED |     20      | PRIMARY KEY, AUTO_INCREMENT                 |         -         | المعرّف الفريد للمهمة                                   |
| `team_id`     | BIGINT UNSIGNED |     20      | FOREIGN KEY (`teams.id`) ON DELETE CASCADE  |         -         | الفريق التابعة له هذه المهمة                            |
| `assigned_to` | BIGINT UNSIGNED |     20      | FOREIGN KEY (`users.id`) ON DELETE SET NULL |       NULL        | العضو المكلف بتنفيذ المهمة                              |
| `title`       | VARCHAR         |     255     | NOT NULL                                    |         -         | عنوان وموضوع المهمة                                     |
| `description` | TEXT            |      -      | NULLABLE                                    |       NULL        | التفاصيل الفنية وخطوات التنفيذ                          |
| `status`      | VARCHAR         |     30      | NOT NULL                                    |      'todo'       | حالة الكانبان (`todo`, `in_progress`, `review`, `done`) |
| `priority`    | VARCHAR         |     20      | NOT NULL                                    |     'medium'      | درجة الأولوية (`urgent`, `high`, `medium`, `low`)       |
| `due_date`    | DATE            |      -      | NULLABLE                                    |       NULL        | الموعد النهائي لتسليم المهمة                            |

### 15.3 جدول وثائق ومخرجات المشروع (`team_documents`)

| اسم الحقل     | نوع البيانات    | الطول/السعة | القيود (Constraints)                       | القيمة الافتراضية | الوصف التفصيلي                                   |
| ------------- | --------------- | :---------: | ------------------------------------------ | :---------------: | ------------------------------------------------ |
| `id`          | BIGINT UNSIGNED |     20      | PRIMARY KEY, AUTO_INCREMENT                |         -         | المعرّف الفريد للوثيقة                           |
| `team_id`     | BIGINT UNSIGNED |     20      | FOREIGN KEY (`teams.id`) ON DELETE CASCADE |         -         | الفريق المالك للوثيقة                            |
| `uploaded_by` | BIGINT UNSIGNED |     20      | FOREIGN KEY (`users.id`) ON DELETE CASCADE |         -         | العضو الذي قام برفع الملف                        |
| `title`       | VARCHAR         |     255     | NOT NULL                                   |         -         | اسم وعنوان الوثيقة المعروض                       |
| `category`    | VARCHAR         |     50      | NOT NULL                                   |    'technical'    | التصنيف (`technical`, `architecture`, `reports`) |
| `file_path`   | VARCHAR         |     255     | NOT NULL                                   |         -         | المسار الفيزيائي للتخزين في الخادم               |
| `file_name`   | VARCHAR         |     255     | NOT NULL                                   |         -         | الاسم الأصلي للملف المرفوع                       |
| `file_size`   | BIGINT UNSIGNED |     20      | NOT NULL                                   |         0         | حجم الملف مقاساً بالبايت (Bytes)                 |
| `version`     | VARCHAR         |     20      | NOT NULL                                   |      'v1.0'       | وسم الإصدار البرمجي للوثيقة                      |

### 15.4 جدول استشارات وتوجيه الخبراء (`team_consultations`)

| اسم الحقل         | نوع البيانات     | الطول/السعة | القيود (Constraints)                       | القيمة الافتراضية | الوصف التفصيلي                                   |
| ----------------- | ---------------- | :---------: | ------------------------------------------ | :---------------: | ------------------------------------------------ |
| `id`              | BIGINT UNSIGNED  |     20      | PRIMARY KEY, AUTO_INCREMENT                |         -         | المعرّف الفريد للاستشارة                         |
| `team_id`         | BIGINT UNSIGNED  |     20      | FOREIGN KEY (`teams.id`) ON DELETE CASCADE |         -         | الفريق المستفيد من التوجيه                       |
| `requested_by`    | BIGINT UNSIGNED  |     20      | FOREIGN KEY (`users.id`) ON DELETE CASCADE |         -         | القائد أو العضو صاحب الطلب                       |
| `consultant_name` | VARCHAR          |     150     | NOT NULL                                   |         -         | اسم المستشار أو الأستاذ الأكاديمي                |
| `topic`           | VARCHAR          |     255     | NOT NULL                                   |         -         | موضوع الاستشارة ومحور النقاش                     |
| `status`          | VARCHAR          |     30      | NOT NULL                                   |     'pending'     | حالة الطلب (`pending`, `confirmed`, `completed`) |
| `session_date`    | DATETIME         |      -      | NULLABLE                                   |       NULL        | الموعد والوقت المعتمد للجلسة                     |
| `meeting_link`    | VARCHAR          |     255     | NULLABLE                                   |       NULL        | رابط الاجتماع الافتراضي (Google Meet)            |
| `recommendations` | TEXT             |      -      | NULLABLE                                   |       NULL        | التوصيات الفنية الملزمة المكتوبة من الخبير       |
| `rating`          | TINYINT UNSIGNED |      1      | NULLABLE                                   |       NULL        | تقييم الجلسة من قبل الفريق (1 - 5)               |

---

## 16. لغة النمذجة الموحدة (UML - Unified Modeling Language)

### a. مخطط حالات الاستخدام (Use Case Diagram)

يوضح هذا المخطط الفاعلين (Actors) والعمليات الوظيفية الرئيسية التي يقدمها النظام لكل فئة:

```mermaid
flowchart LR
    Leader((قائد الفريق))
    Member((عضو الفريق))
    Advisor((المستشار الأكاديمي))
    Sponsor((الشركة الراعية))

    subgraph AuthSys["نظام إدارة الهوية والصلاحيات"]
        UC1[تسجيل الدخول وإنشاء حساب]
        UC2[إدارة الملف المهني والـ CV]
    end

    subgraph TeamSys["مساحة عمل وإدارة الفريق"]
        UC3[تأسيس مشروع الفريق وتوليد الكود]
        UC4[إرسال وقبول دعوات الانضمام]
        UC5[إدارة لوحة مهام الكانبان]
        UC6[رفع وأرشفة وثائق الخزانة]
        UC7[تدوين نقاشات غرفة العمليات]
        UC8[تصدير التقرير التنفيذي الشامل]
    end

    subgraph AdvSys["منظومة الاستشارات والتحكيم"]
        UC9[طلب حجز جلسة استشارية]
        UC10[اعتماد الجلسة وتوثيق التوصيات]
        UC11[تحكيم مخرجات ومشاريع الفرق]
    end

    subgraph SponSys["بوابة الاستثمار والرعاية"]
        UC12[استكشاف المشاريع Deal Flow]
        UC13[طرح التحديات البرمجية والمكافآت]
        UC14[تقديم طلب رعاية وتبني المشروع]
    end

    Leader --> UC1 & UC2 & UC3 & UC4 & UC5 & UC6 & UC7 & UC8 & UC9
    Member --> UC1 & UC2 & UC4 & UC5 & UC6 & UC7
    Advisor --> UC1 & UC2 & UC10 & UC11
    Sponsor --> UC1 & UC12 & UC13 & UC14

    style Leader fill:#e0e7ff,stroke:#4f46e5;
    style Member fill:#f1f5f9,stroke:#64748b;
    style Advisor fill:#dcfce7,stroke:#16a34a;
    style Sponsor fill:#fef3c7,stroke:#d97706;
```

---

### b. مخطط الفئات والكائنات (Class Diagram)

يوضح المخطط التالي بنية الكائنات (Models) في إطار Laravel مع الحقول الأساسية والدوال والعلاقات البرمجية:

```mermaid
classDiagram
    class User {
        +bigint id
        +string name
        +string email
        +string password
        +teams() HasMany
        +memberProfile() HasOne
        +teamMemberships() HasMany
        +assignedTasks() HasMany
    }

    class Team {
        +bigint id
        +bigint leader_id
        +string name
        +string project_title
        +string invite_code
        +int progress_percentage
        +leader() BelongsTo
        +members() HasMany
        +tasks() HasMany
        +documents() HasMany
        +consultations() HasMany
        +calculateProgress() int
    }

    class TeamMember {
        +bigint id
        +bigint team_id
        +bigint user_id
        +string role_in_team
        +string status
        +team() BelongsTo
        +user() BelongsTo
    }

    class TeamTask {
        +bigint id
        +bigint team_id
        +bigint assigned_to
        +string title
        +string status
        +string priority
        +team() BelongsTo
        +assignee() BelongsTo
        +updateStatus(status) void
    }

    class TeamDocument {
        +bigint id
        +bigint team_id
        +string title
        +string file_path
        +string version
        +team() BelongsTo
        +uploader() BelongsTo
    }

    class TeamConsultation {
        +bigint id
        +bigint team_id
        +string consultant_name
        +string status
        +datetime session_date
        +text recommendations
        +confirmSession(date, link) void
        +submitRecommendations(text) void
    }

    User "1" --> "0..*" Team : owns / leads
    User "1" --> "1" TeamMember : acts_as
    Team "1" --> "1..*" TeamMember : includes
    Team "1" --> "0..*" TeamTask : tracks
    Team "1" --> "0..*" TeamDocument : stores
    Team "1" --> "0..*" TeamConsultation : schedules
```

---

### c. مخطط التتابع والتفاعل الزمني (Sequence Diagram)

يوضح المخطط التالي التسلسل الزمني لعملية **حجز جلسة استشارية من قبل قائد الفريق، واعتمادها من المستشار، وتوثيق التوصيات**:

```mermaid
sequenceDiagram
    autonumber
    actor L as قائد الفريق (Leader)
    participant UI as واجهة المنظومة (Frontend)
    participant Ctrl as TeamConsultationController
    participant DB as قاعدة البيانات (PostgreSQL)
    actor C as المستشار الأكاديمي (Advisor)

    L->>UI: اختيار المستشار وتعبئة موضوع الجلسة
    UI->>Ctrl: POST /teams/{team}/consultations
    Ctrl->>DB: INSERT INTO team_consultations (status: 'pending')
    DB-->>Ctrl: Consultation Created (ID: 42)
    Ctrl-->>UI: عرض رسالة نجاح وإرسال إشعار للمستشار

    C->>UI: استعراض طلبات الاستشارة المعلقة
    UI->>Ctrl: GET /advisor/consultations
    Ctrl->>DB: SELECT * WHERE consultant_id = C.id
    DB-->>Ctrl: قائمة الطلبات
    Ctrl-->>UI: عرض الطلب

    C->>UI: قبول الجلسة، تحديد الموعد ورابط Meet
    UI->>Ctrl: PUT /consultations/42/confirm
    Ctrl->>DB: UPDATE team_consultations (status: 'confirmed', session_date, meeting_link)
    DB-->>Ctrl: Updated Successfully
    Ctrl-->>UI: إشعار فوري لقائد الفريق بتأكيد الجلسة

    Note over L, C: انعقاد الجلسة الاستشارية ومراجعة معمارية الكود

    C->>UI: كتابة التوصيات الفنية الرسمية
    UI->>Ctrl: POST /consultations/42/recommendations
    Ctrl->>DB: UPDATE team_consultations (status: 'completed', recommendations)
    DB-->>Ctrl: Saved
    Ctrl-->>UI: توثيق التوصيات في سجل المشروع الرسمي وتحديث نسبة الجاهزية
```

---

### d. مخطط النشاط وسير العمليات (Activity Diagram)

يوضح هذا المخطط سير عمليات **دورة حياة مهمة برمجية في لوحة الكانبان** منذ إنشائها وحتى اكتمالها وتأثيرها على نسبة إنجاز المشروع:

```mermaid
flowchart TD
    Start([بداية: إنشاء مهمة جديدة]) --> InputData[إدخال عنوان المهمة، الوصف، والأولوية]
    InputData --> AssignCheck{هل تم تعيين مطور؟}

    AssignCheck -- نعم --> SetAssignee[إسناد المهمة للمطور وإرسال تنبيه]
    AssignCheck -- لا --> LeaveUnassigned[وضع المهمة في صندوق الانتظار Backlog]

    SetAssignee --> StatusTodo[الحالة: قيد الانتظار Todo]
    LeaveUnassigned --> StatusTodo

    StatusTodo --> MoveInProgress[سحب المهمة إلى جاري العمل In Progress]
    MoveInProgress --> CodingWork[كتابة وتطوير الشيفرة البرمجية]

    CodingWork --> CompleteCode{هل اكتملت البرمجة والاختبار؟}
    CompleteCode -- لا --> CodingWork
    CompleteCode -- نعم --> MoveReview[سحب المهمة إلى المراجعة والتدقيق Review]

    MoveReview --> AuditCheck{هل تمت إجازة الكود من المشرف؟}
    AuditCheck -- لا / توجد ملاحظات --> CodingWork
    AuditCheck -- نعم / معتمد --> MoveDone[سحب المهمة إلى المكتملة Done]

    MoveDone --> CalcProgress[إعادة حساب نسبة تقدم المشروع تلقائياً]
    CalcProgress --> UpdateDashboard[تحديث المؤشر في لوحة قيادة الفريق]
    UpdateDashboard --> EndNode([نهاية النشاط])

    style Start fill:#4f46e5,stroke:#3730a3,color:#ffffff;
    style EndNode fill:#16a34a,stroke:#15803d,color:#ffffff;
    style StatusTodo fill:#f1f5f9,stroke:#64748b;
    style MoveInProgress fill:#fef3c7,stroke:#d97706;
    style MoveReview fill:#e0e7ff,stroke:#6366f1;
    style MoveDone fill:#dcfce7,stroke:#16a34a;
```

---

### e. مخطط الحالة ودورة حياة الكيانات (State Machine Diagram)

يوضح هذا المخطط تحولات الحالات التشغيلية للمشروع البرمجي (`Team Project Lifecycle`):

```mermaid
stateDiagram-v2
    [*] --> مرحلة_الفكرة_Ideation : تأسيس الفريق وتسجيل المشروع

    مرحلة_الفكرة_Ideation --> جاري_التطوير_InProgress : استكمال تشكيلة الفريق وتوزيع أول sprint

    state جاري_التطوير_InProgress {
        [*] --> تخطيط_المهام
        تخطيط_المهام --> تنفيذ_الكانبان
        تنفيذ_الكانبان --> رفع_المستندات_بالخزانة
        رفع_المستندات_بالخزانة --> جلسات_المراجعة_الاستشارية
        جلسات_المراجعة_الاستشارية --> [*]
    }

    جاري_التطوير_InProgress --> قيد_المراجعة_UnderReview : تجاوز نسبة إنجاز المشروع 80%

    قيد_المراجعة_UnderReview --> جاري_التطوير_InProgress : وجود نواقص معمارية أو أمنية
    قيد_المراجعة_UnderReview --> مكتمل_وجاهز_Completed : اعتماد المستشار وصدور التقرير النهائي

    state مكتمل_وجاهز_Completed {
        [*] --> العرض_في_دليل_المشاريع_DealFlow
        العرض_في_دليل_المشاريع_DealFlow --> تلقي_عروض_الرعاية_والاستثمار
        تلقي_عروض_الرعاية_والاستثمار --> المناقشة_والتحكيم_النهائي
    }

    مكتمل_وجاهز_Completed --> [*] : اعتماد التخرج النهائي والتبني التجاري
```

---

## 📌 خاتمة الفصل الثالث

قدم هذا الفصل تحليلاً هندسياً شاملاً ومتكاملاً لمنظومة **TEAM Hub**؛ حيث تم استعراض طرق جمع المتطلبات وتحويلها إلى متطلبات وظيفية وغير وظيفية دقيقة، وتوصيف كامل للمدخلات والمخرجات. كما قدم الفصل النمذجة الهيكلية للبيانات عبر مخططات تدفق البيانات (**DFD**) بمستوييها البيئي والصفري، والمخططات العلائقية لقواعد البيانات (**ERD**) بمستوياتها المنطقية والفيزيائية وقاموس البيانات المفصل، وانتهاءً بالنمذجة الكائنية الشاملة بلغة **UML** بكافة مخططاتها المعيارية؛ مما يجعل هذا التحليل أساساً متيناً وقوياً للانتقال إلى **الفصل الرابع: التصميم المعماري (Design)** وتنفيذه برمجياً بأعلى معايير الجودة.
