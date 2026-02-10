# 🔧 دليل إعداد قاعدة البيانات بعد الرفع

## ❌ المشكلة:
```
SQLSTATE[HY000] [2002] Connection refused
```

هذا الخطأ يعني أن Laravel لا يستطيع الاتصال بخادم MySQL.

---

## ✅ الحل خطوة بخطوة:

### 1️⃣ إنشاء ملف `.env`

في مجلد المشروع الرئيسي، أنشئ ملف `.env` (إذا لم يكن موجوداً):

```bash
# في cPanel Terminal أو SSH
cd /path/to/your/project
cp .env.example .env
```

### 2️⃣ تحديث إعدادات قاعدة البيانات في `.env`

افتح ملف `.env` وعدّل الإعدادات التالية:

```env
APP_NAME=TechBridge
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# تأكد من أن الاتصال هو MySQL وليس SQLite
DB_CONNECTION=mysql

# بيانات قاعدة البيانات من cPanel
DB_HOST=127.0.0.1
# أو إذا كان السيرفر يستخدم localhost:
# DB_HOST=localhost

DB_PORT=3306
DB_DATABASE=اسم_قاعدة_البيانات_من_cPanel
DB_USERNAME=اسم_المستخدم_من_cPanel
DB_PASSWORD=كلمة_المرور_من_cPanel

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

**⚠️ مهم:** 
- لا تستخدم علامات اقتباس ذكية (`"` و `"`)
- لا تضع مسافات قبل أو بعد `=`
- إذا واجهت خطأ "Failed to parse dotenv file"، راجع ملف `ENV_FILE_ERROR_FIX.md`

**مثال:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=username_techbridge
DB_USERNAME=username_dbuser
DB_PASSWORD=your_secure_password
```

### 3️⃣ استيراد قاعدة البيانات

إذا كان لديك ملف SQL (`techbridge.sql`):

#### الطريقة الأولى: من cPanel
1. اذهب إلى **phpMyAdmin** في cPanel
2. اختر قاعدة البيانات التي أنشأتها
3. اضغط على **Import**
4. اختر ملف `techbridge.sql`
5. اضغط **Go**

#### الطريقة الثانية: من Terminal/SSH
```bash
mysql -u username_dbuser -p username_techbridge < database/techbridge.sql
```

### 4️⃣ توليد APP_KEY

```bash
php artisan key:generate
```

### 5️⃣ تشغيل المايجريشن (إذا لم تستورد SQL)

```bash
php artisan migrate --force
```

### 6️⃣ إنشاء رابط التخزين

```bash
php artisan storage:link
```

### 7️⃣ تنظيف الكاش

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 🔍 التحقق من الاتصال:

### اختبار الاتصال من Terminal:

```bash
php artisan tinker
```

ثم في Tinker:
```php
DB::connection()->getPdo();
```

إذا ظهرت رسالة نجاح، الاتصال يعمل! ✅

---

## ⚠️ مشاكل شائعة وحلولها:

### 1. خطأ "Connection refused"
**السبب:** MySQL غير قيد التشغيل أو `DB_HOST` خاطئ

**الحل:**
- تأكد من أن MySQL يعمل في cPanel
- جرب `DB_HOST=localhost` بدلاً من `127.0.0.1`
- تأكد من أن المستخدم لديه صلاحيات على قاعدة البيانات

### 2. خطأ "Access denied"
**السبب:** بيانات المستخدم خاطئة

**الحل:**
- تأكد من `DB_USERNAME` و `DB_PASSWORD` في `.env`
- تأكد من أن المستخدم مضاف لقاعدة البيانات في cPanel

### 3. خطأ "Unknown database"
**السبب:** اسم قاعدة البيانات خاطئ

**الحل:**
- تأكد من `DB_DATABASE` في `.env`
- تأكد من أن قاعدة البيانات موجودة في cPanel

### 4. خطأ "Table doesn't exist"
**السبب:** قاعدة البيانات فارغة

**الحل:**
- استورد ملف `techbridge.sql` من phpMyAdmin
- أو شغّل `php artisan migrate --force`

---

## 📝 ملاحظات مهمة:

1. **أمان ملف `.env`:**
   - تأكد من أن `.env` غير قابل للوصول من المتصفح
   - في cPanel، اضبط الصلاحيات على `600` أو `640`

2. **في Shared Hosting:**
   - عادة `DB_HOST` يكون `127.0.0.1` أو `localhost`
   - اسم قاعدة البيانات عادة يكون: `username_dbname`
   - اسم المستخدم عادة يكون: `username_dbuser`

3. **بعد التعديل:**
   - دائماً نظف الكاش: `php artisan config:clear`

---

## ✅ بعد الإعداد الناجح:

1. اختبر تسجيل الدخول
2. تأكد من أن جميع الصفحات تعمل
3. اختبر إنشاء كورس أو طالب جديد

---

## 🆘 إذا استمرت المشكلة:

1. تحقق من سجلات الأخطاء:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. تحقق من إعدادات MySQL في cPanel

3. تواصل مع دعم الاستضافة للتأكد من أن MySQL يعمل

