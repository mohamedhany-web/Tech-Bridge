<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechBridgeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم إداري (Super Admin)
        User::firstOrCreate(
            ['phone' => '0500000000'],
            [
                'name' => 'المدير العام',
                'email' => 'admin@techbridge.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // إنشاء مدرب (Instructor)
        User::firstOrCreate(
            ['phone' => '0500000001'],
            [
                'name' => 'أحمد المدرب',
                'email' => 'instructor@techbridge.com',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
                'is_active' => true,
                'bio' => 'مدرب برمجة محترف مع أكثر من 10 سنوات من الخبرة',
            ]
        );

        // إنشاء طالب (Student)
        User::firstOrCreate(
            ['phone' => '0500000002'],
            [
                'name' => 'فاطمة الطالبة',
                'email' => 'student@techbridge.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ تم إنشاء المستخدمين بنجاح!');
        $this->command->info('');
        $this->command->info('📋 بيانات الدخول:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👨‍💼 المدير العام (Super Admin):');
        $this->command->info('   📱 رقم الهاتف: 0500000000');
        $this->command->info('   📧 البريد: admin@techbridge.com');
        $this->command->info('   🔑 كلمة المرور: password123');
        $this->command->info('');
        $this->command->info('👨‍🏫 المدرب (Instructor):');
        $this->command->info('   📱 رقم الهاتف: 0500000001');
        $this->command->info('   📧 البريد: instructor@techbridge.com');
        $this->command->info('   🔑 كلمة المرور: password123');
        $this->command->info('');
        $this->command->info('👨‍🎓 الطالب (Student):');
        $this->command->info('   📱 رقم الهاتف: 0500000002');
        $this->command->info('   📧 البريد: student@techbridge.com');
        $this->command->info('   🔑 كلمة المرور: password123');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}

