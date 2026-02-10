# ⚡ إصلاح سريع لمشكلة قاعدة البيانات

## المشكلة:
```
SQLSTATE[HY000] [2002] Connection refused
```

## الحل السريع (3 خطوات):

### 1️⃣ أنشئ ملف `.env` في المجلد الرئيسي:

انسخ هذا المحتوى:

```env
APP_NAME=TechBridge
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# ⚠️ مهم جداً: غير هذه القيم ببياناتك من cPanel
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=اسم_قاعدة_البيانات_هنا
DB_USERNAME=اسم_المستخدم_هنا
DB_PASSWORD=كلمة_المرور_هنا

SESSION_DRIVER=database
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=TechBridge

FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
CACHE_STORE=file
SESSION_SECURE_COOKIE=false
```

**⚠️ ملاحظة مهمة:**
- لا تستخدم علامات اقتباس في ملف `.env` إلا إذا كانت القيمة تحتوي على مسافات
- إذا أردت استخدام مسافات، استخدم علامات اقتباس عادية: `APP_NAME="Tech Bridge"` (وليس ذكية)
- الأفضل: تجنب المسافات واستخدم: `APP_NAME=TechBridge`

### 2️⃣ استورد قاعدة البيانات:

- اذهب إلى **phpMyAdmin** في cPanel
- اختر قاعدة البيانات
- اضغط **Import**
- اختر ملف `database/techbridge.sql`
- اضغط **Go**

### 3️⃣ شغّل هذه الأوامر:

```bash
php artisan key:generate
php artisan config:clear
php artisan cache:clear
```

---

## ✅ جاهز!

جرب فتح الموقع الآن. إذا استمرت المشكلة، راجع `DATABASE_SETUP_GUIDE.md` للحلول التفصيلية.

