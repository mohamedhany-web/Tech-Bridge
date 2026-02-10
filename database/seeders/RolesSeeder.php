<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء دور Super Admin مع جميع الصلاحيات (للإدمن فقط)
        $superAdmin = Role::updateOrCreate(
            ['name' => 'Super Admin'],
            [
                'display_name' => 'مدير عام',
                'description' => 'مدير عام للنظام - يمتلك جميع الصلاحيات',
            ]
        );
        $allPermissions = Permission::all();
        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // دور المدرب - صلاحيات المدرب فقط (بدون صلاحيات إدارة النظام أو المحاسبة...)
        $instructor = Role::updateOrCreate(
            ['name' => 'instructor'],
            [
                'display_name' => 'مدرب',
                'description' => 'مدرب - صلاحيات الكورسات والمحاضرات والمجموعات والواجبات والاختبارات والحضور والمهام',
            ]
        );
        $instructorPermissionIds = Permission::where(function ($q) {
            $q->where('name', 'like', 'instructor.%')
                ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
        })->pluck('id');
        $instructor->permissions()->sync($instructorPermissionIds);

        // دور الطالب - صلاحيات الطالب فقط
        $student = Role::updateOrCreate(
            ['name' => 'student'],
            [
                'display_name' => 'طالب',
                'description' => 'طالب - صلاحيات تصفح الكورسات وكورساتي وطلباتي والفواتير والشهادات والإنجازات',
            ]
        );
        $studentPermissionIds = Permission::where(function ($q) {
            $q->where('name', 'like', 'student.%')
                ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
        })->pluck('id');
        $student->permissions()->sync($studentPermissionIds);

        $this->command->info('تم إنشاء أدوار Super Admin ومدرب وطالب مع صلاحياتهم بنجاح!');
    }
}
