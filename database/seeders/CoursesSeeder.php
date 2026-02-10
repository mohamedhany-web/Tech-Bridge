<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n📚 إضافة كورسات تجريبية...\n";
        echo "=" . str_repeat("=", 60) . "\n";

        // الحصول على مدرب
        $instructor = User::where('role', 'instructor')->where('is_active', true)->first() 
                     ?? User::where('role', 'admin')->where('is_active', true)->first()
                     ?? User::first();

        $instructorId = $instructor->id ?? null;

        // كورسات تجريبية متنوعة
        $courses = [
            [
                'title' => 'مقدمة في البرمجة - JavaScript',
                'description' => 'كورس شامل لتعلم أساسيات JavaScript من الصفر. ستعلم كيفية كتابة الأكواد البرمجية، استخدام المتغيرات والدوال، والعمل مع DOM.',
                'objectives' => 'فهم أساسيات JavaScript، كتابة الكود البرمجي، التعامل مع DOM',
                'level' => 'beginner',
                'duration_hours' => 30,
                'price' => 299,
                'is_free' => false,
                'is_featured' => true,
                'programming_language' => 'JavaScript',
                'requirements' => 'لا توجد متطلبات مسبقة',
                'what_you_learn' => 'تعلم JavaScript من الصفر، كتابة الكود البرمجي، بناء مشاريع عملية',
            ],
            [
                'title' => 'Python للمبتدئين',
                'description' => 'ابدأ رحلتك في تعلم Python مع هذا الكورس الشامل. تعلم أساسيات اللغة البرمجية الأكثر شعبية في العالم.',
                'objectives' => 'تعلم Python من الصفر، فهم البرمجة الكائنية، بناء مشاريع عملية',
                'level' => 'beginner',
                'duration_hours' => 40,
                'price' => 349,
                'is_free' => false,
                'is_featured' => true,
                'programming_language' => 'Python',
                'requirements' => 'لا توجد متطلبات مسبقة',
                'what_you_learn' => 'Python basics، Data structures، Functions، OOP',
            ],
            [
                'title' => 'تطوير الويب الكامل - Full Stack',
                'description' => 'كورس شامل لتعلم تطوير الويب من الصفر إلى الاحتراف. HTML, CSS, JavaScript, React, Node.js وغيرها.',
                'objectives' => 'بناء مواقع ويب كاملة، تعلم Frontend و Backend، نشر المشاريع',
                'level' => 'intermediate',
                'duration_hours' => 80,
                'price' => 599,
                'is_free' => false,
                'is_featured' => true,
                'programming_language' => 'JavaScript',
                'category' => 'Web Development',
                'requirements' => 'معرفة أساسية بالبرمجة',
                'what_you_learn' => 'HTML/CSS، JavaScript، React، Node.js، Databases',
            ],
            [
                'title' => 'React المتقدم',
                'description' => 'تعلم React بشكل متقدم مع Hooks، State Management، وبناء تطبيقات معقدة.',
                'objectives' => 'إتقان React، استخدام Hooks، State Management، بناء تطبيقات واقعية',
                'level' => 'advanced',
                'duration_hours' => 50,
                'price' => 449,
                'is_free' => false,
                'is_featured' => false,
                'programming_language' => 'JavaScript',
                'framework' => 'React',
                'requirements' => 'معرفة JavaScript و React أساسيات',
                'what_you_learn' => 'React Hooks، Redux، Context API، Performance Optimization',
            ],
            [
                'title' => 'Node.js و Express.js',
                'description' => 'تعلم بناء واجهات برمجية (APIs) وخدمات خلفية باستخدام Node.js و Express.js.',
                'objectives' => 'بناء REST APIs، فهم Backend Development، التعامل مع Databases',
                'level' => 'intermediate',
                'duration_hours' => 45,
                'price' => 399,
                'is_free' => false,
                'is_featured' => false,
                'programming_language' => 'JavaScript',
                'framework' => 'Express.js',
                'requirements' => 'معرفة JavaScript',
                'what_you_learn' => 'Node.js، Express.js، REST APIs، MongoDB، Authentication',
            ],
            [
                'title' => 'HTML & CSS للمبتدئين',
                'description' => 'كورس شامل لتعلم HTML و CSS من الصفر. بناء صفحات ويب جميلة ومتجاوبة.',
                'objectives' => 'تعلم HTML و CSS، بناء صفحات ويب، Responsive Design',
                'level' => 'beginner',
                'duration_hours' => 25,
                'price' => 199,
                'is_free' => false,
                'is_featured' => false,
                'category' => 'Web Development',
                'requirements' => 'لا توجد متطلبات مسبقة',
                'what_you_learn' => 'HTML Tags، CSS Styling، Flexbox، Grid، Responsive Design',
            ],
            [
                'title' => 'PHP و Laravel',
                'description' => 'تعلم PHP و إطار عمل Laravel لبناء تطبيقات ويب قوية وآمنة.',
                'objectives' => 'تعلم PHP، فهم Laravel Framework، بناء تطبيقات كاملة',
                'level' => 'intermediate',
                'duration_hours' => 60,
                'price' => 499,
                'is_free' => false,
                'is_featured' => true,
                'programming_language' => 'PHP',
                'framework' => 'Laravel',
                'requirements' => 'معرفة أساسية بالبرمجة',
                'what_you_learn' => 'PHP Basics، Laravel Framework، MVC Pattern، Database',
            ],
            [
                'title' => 'البرمجة الكائنية - OOP',
                'description' => 'فهم مفاهيم البرمجة الكائنية والتوجه للكائنات في البرمجة.',
                'objectives' => 'فهم OOP Concepts، Classes و Objects، Inheritance، Polymorphism',
                'level' => 'intermediate',
                'duration_hours' => 35,
                'price' => 299,
                'is_free' => false,
                'is_featured' => false,
                'category' => 'Programming Concepts',
                'requirements' => 'معرفة أساسية بأي لغة برمجية',
                'what_you_learn' => 'Classes، Objects، Inheritance، Encapsulation، Polymorphism',
            ],
            [
                'title' => 'قواعد البيانات - SQL',
                'description' => 'تعلم قواعد البيانات وإدارة البيانات باستخدام SQL.',
                'objectives' => 'فهم قواعد البيانات، تعلم SQL، تصميم Databases',
                'level' => 'beginner',
                'duration_hours' => 30,
                'price' => 249,
                'is_free' => false,
                'is_featured' => false,
                'category' => 'Database',
                'requirements' => 'لا توجد متطلبات مسبقة',
                'what_you_learn' => 'SQL Queries، Database Design، Normalization، Relationships',
            ],
            [
                'title' => 'Algorithms و Data Structures',
                'description' => 'تعلم الخوارزميات وهياكل البيانات لتحسين مهاراتك البرمجية.',
                'objectives' => 'فهم Algorithms، Data Structures، Problem Solving',
                'level' => 'advanced',
                'duration_hours' => 70,
                'price' => 649,
                'is_free' => false,
                'is_featured' => true,
                'category' => 'Computer Science',
                'requirements' => 'معرفة متقدمة بالبرمجة',
                'what_you_learn' => 'Algorithms، Data Structures، Complexity Analysis، Problem Solving',
            ],
            [
                'title' => 'Vue.js من الصفر',
                'description' => 'تعلم Vue.js لإطار عمل JavaScript الحديث لبناء واجهات مستخدم تفاعلية.',
                'objectives' => 'تعلم Vue.js، بناء Single Page Applications، State Management',
                'level' => 'intermediate',
                'duration_hours' => 40,
                'price' => 379,
                'is_free' => false,
                'is_featured' => false,
                'programming_language' => 'JavaScript',
                'framework' => 'Vue.js',
                'requirements' => 'معرفة JavaScript و HTML/CSS',
                'what_you_learn' => 'Vue.js Basics، Components، Vuex، Vue Router',
            ],
            [
                'title' => 'Flutter لتطوير التطبيقات',
                'description' => 'تعلم Flutter لبناء تطبيقات موبايل متعددة المنصات باستخدام Dart.',
                'objectives' => 'بناء تطبيقات موبايل، تعلم Flutter Framework، نشر التطبيقات',
                'level' => 'intermediate',
                'duration_hours' => 55,
                'price' => 549,
                'is_free' => false,
                'is_featured' => true,
                'programming_language' => 'Dart',
                'framework' => 'Flutter',
                'requirements' => 'معرفة أساسية بالبرمجة',
                'what_you_learn' => 'Flutter Basics، Widgets، State Management، App Publishing',
            ],
            [
                'title' => 'Git و GitHub',
                'description' => 'تعلم إدارة المشاريع البرمجية باستخدام Git و GitHub.',
                'objectives' => 'فهم Git، استخدام GitHub، إدارة المشاريع، Collaboration',
                'level' => 'beginner',
                'duration_hours' => 20,
                'price' => 0,
                'is_free' => true,
                'is_featured' => false,
                'category' => 'Tools',
                'requirements' => 'لا توجد متطلبات مسبقة',
                'what_you_learn' => 'Git Commands، GitHub، Branching، Pull Requests، Collaboration',
            ],
            [
                'title' => 'Docker و DevOps',
                'description' => 'تعلم Docker و DevOps لتحسين عملية التطوير والنشر.',
                'objectives' => 'فهم Docker، CI/CD، DevOps Practices، Containerization',
                'level' => 'advanced',
                'duration_hours' => 45,
                'price' => 599,
                'is_free' => false,
                'is_featured' => false,
                'category' => 'DevOps',
                'requirements' => 'معرفة بالبرمجة والنظم',
                'what_you_learn' => 'Docker، Kubernetes، CI/CD، DevOps Tools',
            ],
        ];

        $created = 0;
        foreach ($courses as $courseData) {
            // التحقق من وجود الكورس أولاً
            $exists = DB::table('advanced_courses')
                ->where('title', $courseData['title'])
                ->exists();
            
            if ($exists) {
                echo "ℹ️  الكورس موجود مسبقاً: {$courseData['title']}\n";
                continue;
            }
            
            // إنشاء الكورس باستخدام DB facade مباشرة
            DB::table('advanced_courses')->insert([
                'title' => $courseData['title'],
                'description' => $courseData['description'] ?? null,
                'objectives' => $courseData['objectives'] ?? null,
                'level' => $courseData['level'] ?? 'beginner',
                'duration_hours' => $courseData['duration_hours'] ?? 0,
                'price' => $courseData['price'] ?? 0,
                'is_free' => $courseData['is_free'] ?? false,
                'is_featured' => $courseData['is_featured'] ?? false,
                'is_active' => true,
                'programming_language' => $courseData['programming_language'] ?? null,
                'framework' => $courseData['framework'] ?? null,
                'category' => $courseData['category'] ?? null,
                'requirements' => $courseData['requirements'] ?? null,
                'what_you_learn' => $courseData['what_you_learn'] ?? null,
                'instructor_id' => $instructorId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $created++;
            echo "✅ تم إنشاء كورس: {$courseData['title']} - السعر: " . ($courseData['price'] ?? 0) . " ج.م\n";
        }

        echo "\n🎉 تم إنشاء {$created} كورس تجريبي بنجاح!\n";
        echo "=" . str_repeat("=", 60) . "\n";
    }
}
