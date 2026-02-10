<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->whereIn('status', ['read', 'replied', 'archived']);
            } elseif ($request->status === 'unread') {
                $query->where('status', 'new');
            }
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // إحصائيات (استخدام status: new = غير مقروءة)
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'new')->count(),
            'read' => ContactMessage::whereIn('status', ['read', 'replied', 'archived'])->count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['status' => 'read']);

        return redirect()->back()->with('success', 'تم تحديد الرسالة كمقروءة');
    }

    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['status' => 'new']);

        return redirect()->back()->with('success', 'تم تحديد الرسالة كغير مقروءة');
    }
}



