# وثيقة المواصفات الفنية للنظام

---

## 1. التصور العام للنظام
منصة إدارة متكاملة للمشاريع والفرق مخصصة للشركات البرمجية الصغيرة والناشئة، وتتكون من:
* **موقع ويب (Web Application)**
* **تطبيق هاتف محمول (Mobile Application)**

---

## 2. الواجهة الخلفية (Backend)
* تم تطويرها باستخدام إطار عمل **Laravel**.

---

## 3. تطبيق الهاتف والموقع (Frontend)
* تم تطويرهما باستخدام **Flutter** لضمان التوافقية وسرعة التطوير ودعم كافة أطراف النظام.

---

## 4. بوابات المستخدمين وصلاحياتهم

### أ. بوابة العميل
* واجهة تفاعلية تتيح للعميل استعراض نسبة إنجاز مشروعه.
* الاطلاع على الفواتير ومتابعة جدول المراحل والتحديثات (دون رؤية تفاصيل الكود الداخلي).

### ب. بوابة الموظفين والمشرفين
* تتبع أداء الموظفين وإنجازاتهم من قبل المشرفين.
* نظام بروفايلات متكامل يضم: السير الذاتية، الخبرات، المعرفة البرمجية، والمشاريع السابقة المربوطة بـ GitHub.
* إدارة العُهد الشخصية، مواصفات الأجهزة، والحالة الصحية للموظفين.
* نظام اقتراحات ذكية لتحسين الأداء وتطوير المهارات.

### ج. لوحة إدارة المنصة الكلية (للإدارة والمشرفين)
* متابعة جميع المشاريع قيد التنفيذ.
* مقارنة الإنجازات الفعلية بالميزانية والجدول الزمني المحدد.
* ميزة تتبع النشاط وساعات العمل الفعلي، حيث يمكن للمشرفين فقط الاطلاع على تقارير تفصيلية تتضمن: وقت تسجيل الدخول، ساعات النشاط، وحجم العمل المنجز مثل الكومنتات والعمليات المختلفة (مع ضمان خصوصية هذه البيانات بين أفراد الفريق).

---

## 5. تكامل GitHub و DevOps
* **الربط الآلي:** الربط المباشر مع مستودعات الأكواد عبر **GitHub**.
* **أتمتة المهام:** تغيير حالة المهام تلقائياً بمجرد رفع العمل (`Push`) أو فتح طلبات الدمج (`Pull Request`).
* **مراجعة الكود:** استعراض الكود والتعليقات المباشرة من GitHub داخل المنصة.
* **أتمتة التشغيل:** إدارة بيئات العمل والإنتاج ومراقبة النشر التلقائي (**DevOps & CI/CD**).
* **سجل التحديثات:** توليد تلقائي لسجل التحديثات (`Changelogs`) الموجه للعملاء بناءً على المهام المنجزة والمدمجة.

---

## 6. ميزات الذكاء الاصطناعي (AI) والاستشارات
* **التخطيط والتحليل:** دمج الذكاء الاصطناعي للمساعدة في التحليل والتخطيط وتصميم دورات العمل (`Workflow`).
* **معايير البرمجة:** تدريب نماذج الذكاء الاصطناعي على أنماط كتابة الأكواد القياسية الخاصة بالشركة.
* **التطوير المهني:** تقديم اقتراحات مخصصة (نصوص، فيديو، ملفات PDF) للموظفين لتطوير مهاراتهم.
* **التسعير الذكي:** حساب تكاليف المشاريع الجديدة تلقائياً وتوليد مقترحات ونطاق العقود بناءً على البيانات المدخلة.
* **دعم النماذج:** دعم كامل للغة العربية عبر API (مثل ChatGPT 4.0) أو محلياً عبر نموذج (Ollama 3.0).
* **الدعم الداخلي:** توجيه الموظفين ذوي الخبرة لتقديم الاستشارات والدعم الفني لبقية أعضاء الفريق.

---

## 7. المالية وإدارة الموارد
* **إدارة المخاطر:** التنبؤ المبكر بالتأخير في المشاريع، مع حساب التكاليف والأرباح المتوقعة.
* **التوزيع الذكي:** توزيع المهام آلياً بناءً على تخصص الموظف وضغط العمل الحالي.
* **إدارة العقود:** دعم العقود الإلكترونية والتوقيع الرقمي للموظفين، المستقلين (Freelancers)، والعملاء.
* **التقارير الدوريّة:** تتبع حالة الموظفين وإصدار تقارير منتظمة (يومية، أسبوعية، شهرية).
* **الاستشارات الخارجية:** ربط المنصة بخبراء السوق لتقديم الاستشارات للشركة البرمجية.

---

Here are the three detailed, ful
### 1. Mobile App Prompt (Flutter)

> **UI/UX design for a mobile app (built with Flutter) for software agency management:**
> A modern, clean, and responsive mobile interface featuring:
> * **Client Portal:** Project progress tracking, milestone timeline, and invoice viewing.
> * **Employee Portal:** Personal profiles displaying assigned hardware specs, skill development recommendations, and performance records.
> * **Supervisor View:** Daily activity summary and active work hour tracking.
> Designed with a sleek, user-friendly mobile layout.
> 
> 

---

### 2. Web Application Prompt (Web)

> **UI/UX design for a comprehensive web application for managing software development agencies:**
> A modern wide-layout web interface featuring:
> * **Client Dashboard:** Detailed project roadmap, deliverable files, and electronic invoices.
> * **Developer Workspace:** Interactive Kanban boards integrated with GitHub to track code commits, pull requests, and review comments.
> * **Finance & Resources:** Risk prediction for delays, project cost analysis, and digital contract signing.
> * **AI Assistance:** Chat interface for project workflow planning and automated task distribution.
> 
> 

---

### 3. Management Dashboard Prompt (Admin & Supervisor Dashboard)

> **UI/UX design for an advanced Admin & Supervisor Dashboard in Dark Theme:**
> A professional, data-driven dashboard focused on analytics and team oversight, including:
> * **Activity & Time Tracking:** Detailed reports per employee showing login timestamps, active work hours, comment counts, and completed actions (restricted strictly to supervisors).
> * **DevOps Metrics:** Live CI/CD pipeline visual statuses and deployment environments monitoring.
> * **Financial & Performance Analytics:** Interactive charts comparing project budgets against actual burn rates and profitability.
> * **Resource Management:** Workload distribution maps and delay forecasting.
> 
>

---

## 8. النموذج التفاعلي (Interactive HTML/CSS/JS Prototype)

تم بناء نموذج تفاعلي كامل بلغات الويب الأساسية (HTML, CSS, JS) يستعرض الأنظمة الثلاثة للوكالة بطريقة عصرية ومترابطة:

1. **البوابة الرئيسية (Launchpad Portal - `index.html`):** نقطة الانطلاق والتعريف بالأنظمة الثلاثة مع بطاقات متحركة جذابة.
2. **تطبيق الهاتف (Flutter Simulator - `mobile.html`):** واجهة محاكاة لهاتف ذكي تتيح للعملاء والموظفين والمشرفين التفاعل مع حساباتهم في تطبيق الهاتف المصمم بـ Flutter.
3. **موقع الويب المتكامل (Web Workspace - `web.html`):** واجهة ويب عريضة مخصصة للمطورين والعملاء، تشمل لوحة كانبان تفاعلية، ولوحة توقيع إلكتروني للعقود، ومساعد ذكاء اصطناعي تفاعلي لتوليد المهام.
4. **لوحة التحكم المتقدمة (Supervisor Dashboard - `dashboard.html`):** لوحة مراقبة بالسمة الداكنة (Dark Theme) تستعرض أداء الموظفين التفصيلي، تحليلات مالية، ومسار نشر DevOps مباشر تفاعلي.

### هيكل ملفات النموذج:
* `index.html` (بوابة الدخول)
* `mobile.html` (شاشة محاكي تطبيق الموبايل)
* `web.html` (شاشة موقع الويب ومساحة العمل)
* `dashboard.html` (شاشة لوحة تحكم المشرفين والإدارة)
* `css/global.css` (التنسيقات والخطوط والمتغيرات العامة للنظام)
* `css/mobile.css` (تنسيقات محاكي الهاتف والتبويبات)
* `css/web.css` (تنسيقات لوحة المهام والدردشة والتوقيع الرقمي)
* `css/dashboard.css` (تنسيقات السمة الداكنة المتقدمة للوحة الإشراف)
* `js/mobile.js` (المنطق البرمجي لتطبيق الموبايل وتتبع الوقت)
* `js/web.js` (المنطق البرمجي لموقع الويب ولوحة المهام وسحبها)
* `js/dashboard.js` (المنطق البرمجي لتصفية بيانات الموظفين وعرض نافذة التفاصيل)