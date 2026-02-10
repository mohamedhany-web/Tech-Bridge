# دليل رفع المشروع على الاستضافة

## المشاكل التي تم حلها:

### 1. مشكلة جدول sessions
**الخطأ:** `no such table: sessions`

**الحل:**
- تشغيل الأمر: `php artisan session:table`
- ثم: `php artisan migrate`
- أو تغيير `SESSION_DRIVER=file` في `.env`

### 2. مشكلة تعديل الأعمدة في SQLite
**الخطأ:** `General error: 1 near ")": syntax error`

**الحل:** تم تحديث جميع ملفات الهجرة (migrations) لتتخطى عمليات `->change()` عند استخدام SQLite.

---

## خطوات رفع المشروع على الاستضافة:

### 1. تجهيز الملفات

```bash
# على جهازك المحلي
composer install --no-dev --optimize-autoloader
npm run build
```

### 2. رفع الملفات

ارفع جميع ملفات المشروع إلى السيرفر عدا:
- `node_modules/`
- `.env` (سننشئه على السيرفر)
- `storage/` و `bootstrap/cache/` (نظفهم على السيرفر)

### 3. إعدادات السيرفر

#### أ. إنشاء ملف `.env`:

```bash
cp .env.example .env
```

عدّل `.env` بالإعدادات التالية:

```env
APP_NAME="Tech Bridge"
APP_ENV=production
APP_KEY=  # سنولدها بعد قليل
APP_DEBUG=false
APP_URL=https://your-domain.com

# إعدادات قاعدة البيانات
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database/database.sqlite

# إعدادات الجلسات (اختر واحد)
SESSION_DRIVER=file
# أو
SESSION_DRIVER=database

# باقي الإعدادات...
```

#### ب. إنشاء قاعدة البيانات:

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

#### ج. ضبط الصلاحيات:

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache database
```

### 4. تشغيل أوامر Laravel

```bash
# توليد مفتاح التطبيق
php artisan key:generate

# إنشاء جدول الجلسات (إذا كنت تستخدم SESSION_DRIVER=database)
php artisan session:table

# تشغيل الهجرات
php artisan migrate --force

# تشغيل السيدرز (البيانات الأولية)
php artisan db:seed --force

# ربط مجلد التخزين
php artisan storage:link

# مسح الكاش
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
```

### 5. إعدادات Apache/Nginx

#### Apache (.htaccess في public):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 6. التحقق من الإعدادات

- تأكد أن `public/` هو الجذر الرئيسي للموقع
- تأكد من صلاحيات الملفات
- تحقق من لوجات الأخطاء في `storage/logs/`

---

## حل المشاكل الشائعة:

### مشكلة: "Route not defined"
**الحل:** تشغيل `php artisan route:clear && php artisan route:cache`

### مشكلة: صور الملفات الشخصية لا تظهر
**الحل:** 
```bash
php artisan storage:link
chmod -R 755 public/profile-photos
```

### مشكلة: أخطاء في الهجرات
**الحل:** 
- حذف قاعدة البيانات وإعادة إنشائها
- تشغيل `php artisan migrate:fresh --seed --force`

### مشكلة: بطء في الأداء
**الحل:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload -o
```

---

## ملاحظات مهمة:

1. **النسخ الاحتياطي:** احتفظ بنسخة احتياطية من قاعدة البيانات بانتظام:
   ```bash
   cp database/database.sqlite database/backup_$(date +%Y%m%d).sqlite
   ```

2. **الأمان:**
   - لا ترفع ملف `.env` إلى Git
   - اجعل `APP_DEBUG=false` في الإنتاج
   - استخدم HTTPS دائماً

3. **المراقبة:**
   - راقب ملفات اللوجات في `storage/logs/`
   - استخدم `php artisan queue:work` للوظائف الخلفية

4. **التحديثات:**
   ```bash
   git pull origin main
   composer install --no-dev
   php artisan migrate --force
   php artisan optimize
   ```

---

## للدعم:

إذا واجهت أي مشكلة، راجع:
- ملفات اللوجات: `storage/logs/laravel.log`
- لوجات السيرفر: `/var/log/apache2/error.log` أو `/var/log/nginx/error.log`
