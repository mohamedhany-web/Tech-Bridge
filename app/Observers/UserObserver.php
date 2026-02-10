<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // تجنب تسجيل النشاط إذا لم يكن هناك مستخدم مسجل دخول
        if (auth()->check()) {
            ActivityLog::logActivity(
                'user_created',
                $user,
                null,
                $user->only(['name', 'email', 'phone', 'role'])
            );
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // تجنب تسجيل النشاط إذا لم يكن هناك مستخدم مسجل دخول
        if (!auth()->check()) {
            return;
        }

        $changes = $user->getChanges();
        
        // تجاهل تحديث last_login_at فقط لتجنب الضوضاء في السجلات
        if (isset($changes['last_login_at']) && count($changes) === 1) {
            return;
        }
        
        // إزالة البيانات الحساسة من التسجيل
        if (isset($changes['password'])) {
            unset($changes['password']);
        }
        if (isset($changes['remember_token'])) {
            unset($changes['remember_token']);
        }
        if (isset($changes['last_login_at'])) {
            unset($changes['last_login_at']);
        }

        if (!empty($changes)) {
            try {
                ActivityLog::logActivity(
                    'user_updated',
                    $user,
                    $user->getOriginal(),
                    $changes
                );
            } catch (\Exception $e) {
                // تجاهل الأخطاء في تسجيل النشاط
                \Log::error('فشل تسجيل نشاط تحديث المستخدم: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if (!auth()->check()) {
            return;
        }
        
        try {
            // حفظ البيانات قبل محاولة الوصول إليها
            $userData = [
                'name' => $user->name ?? null,
                'email' => $user->email ?? null,
                'phone' => $user->phone ?? null,
                'role' => $user->role ?? null,
            ];
            
            ActivityLog::logActivity(
                'user_deleted',
                $user,
                $userData,
                null
            );
        } catch (\Exception $e) {
            // تجاهل الأخطاء في تسجيل النشاط
            \Log::warning('فشل تسجيل نشاط حذف المستخدم في Observer: ' . $e->getMessage());
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        ActivityLog::logActivity(
            'user_restored',
            $user,
            null,
            $user->only(['name', 'email', 'phone', 'role'])
        );
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        ActivityLog::logActivity(
            'user_force_deleted',
            $user,
            $user->only(['name', 'email', 'phone', 'role']),
            null
        );
    }
}