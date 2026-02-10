<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PerformanceController extends Controller
{
    /**
     * عرض صفحة الأداء
     */
    public function index()
    {
        // معلومات النظام
        $systemInfo = $this->getSystemInfo();
        
        // معلومات الأداء
        $performanceInfo = $this->getPerformanceInfo();
        
        // حجم الملفات المؤقتة
        $cacheSizes = $this->getCacheSizes();
        
        return view('admin.performance.index', compact('systemInfo', 'performanceInfo', 'cacheSizes'));
    }

    /**
     * مسح جميع أنواع الكاش
     */
    public function clearCache(Request $request)
    {
        $type = $request->input('type', 'all');
        $results = [];

        try {
            switch ($type) {
                case 'config':
                    Artisan::call('config:clear');
                    $results['config'] = 'تم مسح كاش الإعدادات بنجاح';
                    break;
                    
                case 'route':
                    Artisan::call('route:clear');
                    $results['route'] = 'تم مسح كاش المسارات بنجاح';
                    break;
                    
                case 'view':
                    Artisan::call('view:clear');
                    $results['view'] = 'تم مسح كاش العروض بنجاح';
                    break;
                    
                case 'application':
                    Artisan::call('cache:clear');
                    $results['application'] = 'تم مسح كاش التطبيق بنجاح';
                    break;
                    
                case 'compiled':
                    Artisan::call('clear-compiled');
                    $results['compiled'] = 'تم مسح الملفات المترجمة بنجاح';
                    break;
                    
                case 'all':
                    Artisan::call('config:clear');
                    Artisan::call('route:clear');
                    Artisan::call('view:clear');
                    Artisan::call('cache:clear');
                    Artisan::call('clear-compiled');
                    $results['all'] = 'تم مسح جميع أنواع الكاش بنجاح';
                    break;
            }
            
            return response()->json([
                'success' => true,
                'message' => $results[$type] ?? 'تم المسح بنجاح',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إنشاء الكاش لتحسين الأداء
     */
    public function optimizeCache()
    {
        try {
            $results = [];
            
            // إنشاء كاش الإعدادات
            Artisan::call('config:cache');
            $results['config'] = 'تم إنشاء كاش الإعدادات بنجاح';
            
            // إنشاء كاش المسارات
            Artisan::call('route:cache');
            $results['route'] = 'تم إنشاء كاش المسارات بنجاح';
            
            // إنشاء كاش العروض
            Artisan::call('view:cache');
            $results['view'] = 'تم إنشاء كاش العروض بنجاح';
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحسين الأداء بنجاح',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تنظيف الملفات المؤقتة
     */
    public function clearTempFiles()
    {
        try {
            $cleared = 0;
            $paths = [
                storage_path('logs'),
                storage_path('framework/cache/data'),
                storage_path('framework/sessions'),
                storage_path('framework/views'),
            ];

            foreach ($paths as $path) {
                if (File::exists($path)) {
                    $files = File::allFiles($path);
                    foreach ($files as $file) {
                        if ($file->getMTime() < (time() - 3600)) { // أقدم من ساعة
                            File::delete($file);
                            $cleared++;
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "تم حذف {$cleared} ملف مؤقت بنجاح",
                'cleared' => $cleared
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحسين قاعدة البيانات
     */
    public function optimizeDatabase()
    {
        try {
            $results = [];
            
            // تحسين الجداول
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . DB::getDatabaseName();
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                DB::statement("OPTIMIZE TABLE `{$tableName}`");
                $results[] = "تم تحسين جدول: {$tableName}";
            }
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحسين قاعدة البيانات بنجاح',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على معلومات النظام
     */
    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];
    }

    /**
     * الحصول على معلومات الأداء
     */
    private function getPerformanceInfo()
    {
        return [
            'memory_usage' => $this->formatBytes(memory_get_usage(true)),
            'memory_peak' => $this->formatBytes(memory_get_peak_usage(true)),
            'memory_limit' => ini_get('memory_limit'),
            'disk_free_space' => $this->formatBytes(disk_free_space('/')),
            'disk_total_space' => $this->formatBytes(disk_total_space('/')),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
        ];
    }

    /**
     * الحصول على أحجام الكاش
     */
    private function getCacheSizes()
    {
        $sizes = [];
        
        // كاش الإعدادات
        $configPath = base_path('bootstrap/cache/config.php');
        if (File::exists($configPath)) {
            try {
                $sizes['config'] = $this->formatBytes(File::size($configPath));
            } catch (\Exception $e) {
                $sizes['config'] = '0 B';
            }
        } else {
            $sizes['config'] = '0 B';
        }
        
        // كاش المسارات
        $routesPath = base_path('bootstrap/cache/routes-v7.php');
        if (File::exists($routesPath)) {
            try {
                $sizes['route'] = $this->formatBytes(File::size($routesPath));
            } catch (\Exception $e) {
                $sizes['route'] = '0 B';
            }
        } else {
            $sizes['route'] = '0 B';
        }
        
        // كاش العروض
        $viewCachePath = storage_path('framework/views');
        if (File::exists($viewCachePath) && File::isDirectory($viewCachePath)) {
            try {
                $totalSize = 0;
                $files = File::allFiles($viewCachePath);
                foreach ($files as $file) {
                    $totalSize += $file->getSize();
                }
                $sizes['view'] = $this->formatBytes($totalSize);
            } catch (\Exception $e) {
                $sizes['view'] = '0 B';
            }
        } else {
            $sizes['view'] = '0 B';
        }
        
        // كاش التطبيق
        $appCachePath = storage_path('framework/cache/data');
        if (File::exists($appCachePath) && File::isDirectory($appCachePath)) {
            try {
                $totalSize = 0;
                $files = File::allFiles($appCachePath);
                foreach ($files as $file) {
                    $totalSize += $file->getSize();
                }
                $sizes['application'] = $this->formatBytes($totalSize);
            } catch (\Exception $e) {
                $sizes['application'] = '0 B';
            }
        } else {
            $sizes['application'] = '0 B';
        }
        
        return $sizes;
    }

    /**
     * تنسيق البايتات
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

