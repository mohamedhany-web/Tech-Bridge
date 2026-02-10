<?php
/**
 * ملف إعداد المنصة للـ Shared Hosting
 * ارفع هذا الملف واذهب إليه في المتصفح لإعداد المنصة
 */

// التأكد من أن Laravel محمل
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die('❌ ملفات Laravel غير موجودة. تأكد من رفع جميع الملفات.');
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<h1>🚀 إعداد منصة Tech Bridge</h1>';
echo '<div style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">';

try {
    echo '<h2>📊 فحص المتطلبات</h2>';
    
    // فحص PHP Version
    $phpVersion = PHP_VERSION;
    echo '<p>✅ إصدار PHP: ' . $phpVersion . '</p>';
    
    // فحص ملف .env
    $envPath = __DIR__ . '/.env';
    if (!file_exists($envPath)) {
        echo '<div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3>⚠️ ملف .env غير موجود!</h3>';
        echo '<p>يجب إنشاء ملف <code>.env</code> في المجلد الرئيسي للمشروع.</p>';
        echo '<p><strong>الحل:</strong></p>';
        echo '<ol>';
        echo '<li>انسخ محتوى ملف <code>QUICK_DATABASE_FIX.md</code></li>';
        echo '<li>أنشئ ملف <code>.env</code> في المجلد الرئيسي</li>';
        echo '<li>الصق المحتوى وعدّل بيانات قاعدة البيانات</li>';
        echo '<li>حدّث الصفحة</li>';
        echo '</ol>';
        echo '</div>';
        die();
    }
    
    // فحص إعدادات قاعدة البيانات في .env
    $dbConnection = env('DB_CONNECTION', '');
    if (empty($dbConnection) || $dbConnection === 'sqlite') {
        echo '<div style="background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3>❌ خطأ في إعدادات قاعدة البيانات!</h3>';
        echo '<p>يجب تعيين <code>DB_CONNECTION=mysql</code> في ملف <code>.env</code></p>';
        echo '<p>راجع ملف <code>QUICK_DATABASE_FIX.md</code> للتعليمات</p>';
        echo '</div>';
    }
    
    // فحص قاعدة البيانات
    echo '<h2>🗄️ إعداد قاعدة البيانات</h2>';
    
    // فحص اتصال قاعدة البيانات
    try {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE', 'techbridge');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPass = env('DB_PASSWORD', '');
        
        // محاولة الاتصال
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
        echo '<p>✅ اتصال قاعدة البيانات ناجح</p>';
        echo '<p>📊 قاعدة البيانات: ' . htmlspecialchars($dbName) . '</p>';
        
        // تشغيل المايجريشن
        echo '<h3>📋 تشغيل المايجريشن...</h3>';
        $kernel->call('migrate', ['--force' => true]);
        echo '<p>✅ تم تشغيل المايجريشن بنجاح</p>';
        
        // تشغيل السيدرز
        echo '<h3>📄 تشغيل السيدرز...</h3>';
        try {
            $kernel->call('db:seed', ['--class' => 'MessageTemplateSeeder', '--force' => true]);
            echo '<p>✅ تم تشغيل السيدرز بنجاح</p>';
        } catch (Exception $e) {
            echo '<p>⚠️ السيدرز: ' . $e->getMessage() . '</p>';
        }
        
    } catch (PDOException $e) {
        echo '<div style="background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3>❌ خطأ في الاتصال بقاعدة البيانات</h3>';
        echo '<p><strong>الخطأ:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        
        if (strpos($e->getMessage(), 'Connection refused') !== false) {
            echo '<h4>🔧 الحلول المقترحة:</h4>';
            echo '<ol>';
            echo '<li>تأكد من أن MySQL يعمل في cPanel</li>';
            echo '<li>تحقق من <code>DB_HOST</code> في ملف <code>.env</code> (جرب <code>localhost</code> بدلاً من <code>127.0.0.1</code>)</li>';
            echo '<li>تأكد من <code>DB_PORT=3306</code></li>';
            echo '<li>راجع ملف <code>DATABASE_SETUP_GUIDE.md</code> للحلول التفصيلية</li>';
            echo '</ol>';
        } elseif (strpos($e->getMessage(), 'Access denied') !== false) {
            echo '<h4>🔧 الحلول المقترحة:</h4>';
            echo '<ol>';
            echo '<li>تحقق من <code>DB_USERNAME</code> و <code>DB_PASSWORD</code> في ملف <code>.env</code></li>';
            echo '<li>تأكد من أن المستخدم مضاف لقاعدة البيانات في cPanel</li>';
            echo '<li>تأكد من أن المستخدم لديه جميع الصلاحيات على قاعدة البيانات</li>';
            echo '</ol>';
        } elseif (strpos($e->getMessage(), 'Unknown database') !== false) {
            echo '<h4>🔧 الحلول المقترحة:</h4>';
            echo '<ol>';
            echo '<li>تحقق من <code>DB_DATABASE</code> في ملف <code>.env</code></li>';
            echo '<li>تأكد من أن قاعدة البيانات موجودة في cPanel</li>';
            echo '<li>استورد ملف <code>database/techbridge.sql</code> من phpMyAdmin</li>';
            echo '</ol>';
        }
        
        echo '<p><strong>📝 بيانات الاتصال الحالية:</strong></p>';
        echo '<ul>';
        echo '<li>DB_CONNECTION: ' . htmlspecialchars(env('DB_CONNECTION', 'غير محدد')) . '</li>';
        echo '<li>DB_HOST: ' . htmlspecialchars(env('DB_HOST', 'غير محدد')) . '</li>';
        echo '<li>DB_PORT: ' . htmlspecialchars(env('DB_PORT', 'غير محدد')) . '</li>';
        echo '<li>DB_DATABASE: ' . htmlspecialchars(env('DB_DATABASE', 'غير محدد')) . '</li>';
        echo '<li>DB_USERNAME: ' . htmlspecialchars(env('DB_USERNAME', 'غير محدد')) . '</li>';
        echo '</ul>';
        echo '</div>';
    }
    
    // إنشاء رابط التخزين
    echo '<h2>🔗 إعداد التخزين</h2>';
    try {
        $kernel->call('storage:link');
        echo '<p>✅ تم إنشاء رابط التخزين</p>';
    } catch (Exception $e) {
        echo '<p>⚠️ رابط التخزين: ' . $e->getMessage() . '</p>';
    }
    
    // إنشاء مستخدم إداري أول
    echo '<h2>👤 إنشاء المستخدم الإداري</h2>';
    
    // فحص وجود مستخدم إداري
    $app->make('db')->reconnect();
    
    $adminExists = $app->make('db')->table('users')->where('role', 'admin')->exists();
    
    if (!$adminExists) {
        // إنشاء مستخدم إداري افتراضي
        $app->make('db')->table('users')->insert([
            'name' => 'مدير المنصة',
            'email' => 'admin@platform.com',
            'phone' => '01000000000',
            'password' => password_hash('123456789', PASSWORD_DEFAULT),
            'role' => 'admin',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo '<p>✅ تم إنشاء المستخدم الإداري:</p>';
        echo '<ul>';
        echo '<li><strong>الإيميل:</strong> admin@platform.com</li>';
        echo '<li><strong>كلمة المرور:</strong> 123456789</li>';
        echo '<li><strong>⚠️ غير كلمة المرور فوراً بعد الدخول!</strong></li>';
        echo '</ul>';
    } else {
        echo '<p>✅ المستخدم الإداري موجود مسبقاً</p>';
    }
    
    // تحسين الأداء
    echo '<h2>⚡ تحسين الأداء</h2>';
    try {
        $kernel->call('config:cache');
        echo '<p>✅ تم إنشاء cache الإعدادات</p>';
        
        $kernel->call('route:cache');
        echo '<p>✅ تم إنشاء cache المسارات</p>';
        
        $kernel->call('view:cache');
        echo '<p>✅ تم إنشاء cache العروض</p>';
    } catch (Exception $e) {
        echo '<p>⚠️ تحسين الأداء: ' . $e->getMessage() . '</p>';
    }
    
    echo '<h2>🎉 تم الانتهاء من الإعداد!</h2>';
    echo '<div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">';
    echo '<h3>🔗 الروابط المهمة:</h3>';
    echo '<ul>';
    echo '<li><strong>لوحة الإدارة:</strong> <a href="/admin/dashboard" target="_blank">' . env('APP_URL') . '/admin/dashboard</a></li>';
    echo '<li><strong>صفحة الطلاب:</strong> <a href="/academic-years" target="_blank">' . env('APP_URL') . '/academic-years</a></li>';
    echo '<li><strong>تسجيل الدخول:</strong> <a href="/login" target="_blank">' . env('APP_URL') . '/login</a></li>';
    echo '</ul>';
    echo '</div>';
    
    echo '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">';
    echo '<h3>⚠️ خطوات مهمة بعد الإعداد:</h3>';
    echo '<ol>';
    echo '<li>احذف هذا الملف (setup.php) للأمان</li>';
    echo '<li>سجل دخول كمدير وغير كلمة المرور</li>';
    echo '<li>أضف السنوات الدراسية والمواد</li>';
    echo '<li>اختبر إرسال الرسائل من قسم الرسائل</li>';
    echo '<li>إعداد WhatsApp API إذا كنت تريد استخدامه</li>';
    echo '</ol>';
    echo '</div>';
    
} catch (Exception $e) {
    echo '<h2>❌ خطأ في الإعداد</h2>';
    echo '<p style="color: red;">الخطأ: ' . $e->getMessage() . '</p>';
    echo '<p>تأكد من:</p>';
    echo '<ul>';
    echo '<li>صحة بيانات قاعدة البيانات في ملف .env</li>';
    echo '<li>أذونات المجلدات صحيحة</li>';
    echo '<li>جميع ملفات Laravel مرفوعة</li>';
    echo '</ul>';
}

echo '</div>';
?>

<style>
body {
    font-family: 'Arial', sans-serif;
    direction: rtl;
    background: #f8f9fa;
    margin: 0;
    padding: 20px;
}

h1 {
    color: #2c5aa0;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
}

p, li {
    line-height: 1.6;
    margin: 10px 0;
}

ul, ol {
    padding-right: 20px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.success {
    color: #28a745;
}

.error {
    color: #dc3545;
}

.warning {
    color: #ffc107;
}
</style>
