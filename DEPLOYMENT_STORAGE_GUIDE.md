# دليل حل مشاكل الصور عند الرفع على الاستضافة

## 🔧 المشاكل الشائعة والحلول

### 1. مشكلة الرابط الرمزي (Symbolic Link)

**المشكلة:** على بعض الاستضافات المشتركة، الروابط الرمزية لا تعمل بشكل صحيح.

**الحل البديل:** إنشاء ملف PHP لتوجيه الطلبات إلى storage

#### أ) إنشاء ملف `public/storage/index.php`:

```php
<?php
// public/storage/index.php

$requestedFile = __DIR__ . '/../storage/app/public/' . ltrim($_SERVER['REQUEST_URI'], '/storage/');

if (file_exists($requestedFile)) {
    $mimeType = mime_content_type($requestedFile);
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . filesize($requestedFile));
    readfile($requestedFile);
    exit;
}

http_response_code(404);
echo 'File not found';
```

#### ب) تحديث `.htaccess`:

```apache
# في public/.htaccess
# قبل سطر "Send Requests To Front Controller"
RewriteCond %{REQUEST_URI} ^/storage/(.*)$
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^storage/(.*)$ storage/index.php?file=$1 [L,QSA]
```

### 2. صلاحيات الملفات والمجلدات

**على الخادم، تأكد من صلاحيات صحيحة:**

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 755 public/storage  # إذا كان موجوداً
```

### 3. تحديث APP_URL

**في ملف `.env` على الخادم:**

```env
APP_URL=https://yourdomain.com
# أو
APP_URL=https://www.yourdomain.com
```

**تأكد من عدم وجود مسافة قبل أو بعد الرابط!**

### 4. التحقق من إعدادات Storage

**في `config/filesystems.php`:**

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### 5. إنشاء رابط storage على الخادم

**بعد الرفع، قم بتنفيذ:**

```bash
php artisan storage:link
```

**إذا لم يعمل، استخدم الطريقة البديلة أعلاه.**

### 6. تحديث طريقة عرض الصور في الكود

**استخدم `asset()` بدلاً من `Storage::url()`:**

```php
// ❌ قد لا يعمل على بعض الخوادم
$imageUrl = Storage::disk('public')->url($path);

// ✅ يعمل بشكل أفضل
$imageUrl = asset('storage/' . $path);
```

### 7. التحقق من وجود الملفات

**قبل العرض، تحقق من وجود الملف:**

```php
$fullPath = storage_path('app/public/' . $order->payment_proof);
if (file_exists($fullPath)) {
    $imageUrl = asset('storage/' . $order->payment_proof);
} else {
    // عرض placeholder أو رسالة
}
```

## ✅ قائمة التحقق قبل الرفع

- [ ] تحديث `APP_URL` في `.env`
- [ ] تشغيل `php artisan storage:link` على الخادم
- [ ] التحقق من صلاحيات مجلد `storage`
- [ ] التحقق من صلاحيات مجلد `bootstrap/cache`
- [ ] التحقق من أن مجلد `storage/app/public` موجود
- [ ] التأكد من أن `.htaccess` يسمح بالوصول إلى `/storage/`
- [ ] اختبار رفع صورة بعد النشر

## 🔍 اختبار بعد الرفع

1. **جرب رفع صورة جديدة:**
   - اذهب إلى صفحة طلب كورس
   - ارفع صورة إيصال
   - تحقق من ظهور الصورة

2. **تحقق من المسار:**
   - افتح DevTools (F12)
   - اذهب إلى Network
   - حاول فتح الصورة
   - تحقق من status code (يجب أن يكون 200)

3. **تحقق من الملف على الخادم:**
   ```bash
   ls -la storage/app/public/payment-proofs/
   ```

## 🆘 إذا استمرت المشكلة

### حل سريع: نسخ المجلد مباشرة

إذا لم يعمل الرابط الرمزي:

```bash
# على الخادم
cp -r storage/app/public/* public/storage/
```

**⚠️ ملاحظة:** يجب تحديث هذا يدوياً عند رفع صور جديدة.

### حل أفضل: استخدام Route لعرض الصور

إنشاء route مخصص لعرض الصور:

```php
// routes/web.php
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }
    abort(404);
})->where('path', '.*');
```

