# 📡 توثيق مسارات الـ API المعتمدة — محمد الرقاص
**المشروع:** نظام إدارة ومتابعة المشاريع (PMMS)  
**الخادم الأساسي للتطوير:** `http://localhost:8000/api/v1`  
**آلية المصادقة:** `Authorization: Bearer <SANCTUM_TOKEN>`  

---

## 🔐 1. مسارات المصادقة والمستخدمين (Authentication & Users)

| الطريقة | المسار (Endpoint) | الوصف | الحماية | المعاملات المطلوبة (Body) |
| :---: | :--- | :--- | :---: | :--- |
| `POST` | `/auth/login` | تسجيل دخول وإصدار التوكن | عام | `{"email": "...", "password": "..."}` |
| `POST` | `/auth/logout` | إبطال التوكن الحالي | محمي | فارغ (Bearer Token) |
| `GET` | `/auth/me` | بيانات الحساب والأدوار والصلاحيات | محمي | فارغ (Bearer Token) |

---

## 📁 2. مسارات إدارة المشاريع (Projects API)

| الطريقة | المسار (Endpoint) | الوصف | الحماية | الاستعلامات المتاحة (Query Params) |
| :---: | :--- | :--- | :---: | :--- |
| `GET` | `/projects` | استعراض المشاريع | محمي | `?status=active&department_id=2&page=1` |
| `POST` | `/projects` | إنشاء مشروع جديد | محمي (مدير/مشرف) | `title`, `description`, `budget`, `start_date` |
| `GET` | `/projects/{id}` | تفاصيل المشروع والمراحل | محمي | معرف المشروع في الرابط |
| `PUT` | `/projects/{id}` | تحديث بيانات المشروع | محمي (مدير/مشرف) | حقول التعديل |

---

## 📋 3. البنية المعيارية للاستجابات (Standard JSON Response)

### استجابة النجاح (Success - 200 OK):
```json
{
  "status": "success",
  "message": "تم جلب البيانات بنجاح",
  "data": {
    "id": 1,
    "title": "نظام أتمتة المستودعات",
    "status": "active",
    "progress": 65
  },
  "meta": {
    "timestamp": "2026-11-13T19:00:00Z"
  }
}
```

### استجابة الخطأ (Error - 422 Unprocessable):
```json
{
  "status": "error",
  "message": "بيانات الإدخال غير صالحة",
  "errors": {
    "email": ["البريد الإلكتروني المدخل غير مسجل لدينا"]
  }
}
```

