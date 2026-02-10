<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('user')
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->paginate(20);

        $stats = [
            'total' => Invoice::count(),
            'pending' => Invoice::pending()->count(),
            'paid' => Invoice::paid()->count(),
            'overdue' => Invoice::overdue()->count(),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.invoices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $total = $validated['subtotal'] 
            + ($validated['tax_amount'] ?? 0) 
            - ($validated['discount_amount'] ?? 0);

        // إعطاء قيمة افتراضية للوصف إذا كان فارغاً
        $description = $validated['description'] ?? '';
        if (empty(trim($description))) {
            $typeDescriptions = [
                'course' => 'فاتورة كورس',
                'subscription' => 'فاتورة اشتراك',
                'membership' => 'فاتورة عضوية',
                'other' => 'فاتورة أخرى',
            ];
            $description = $typeDescriptions[$validated['type']] ?? 'فاتورة';
        }

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'description' => $description,
            'subtotal' => $validated['subtotal'],
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'total_amount' => $total,
            'status' => 'pending',
            'due_date' => $validated['due_date'] ?? now()->addDays(30),
            'notes' => $validated['notes'],
            'currency' => 'EGP',
        ]);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('user', 'payments', 'transactions', 'order', 'subscription', 'expense');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.invoices.edit', compact('invoice', 'users'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $total = $validated['subtotal'] 
            + ($validated['tax_amount'] ?? 0) 
            - ($validated['discount_amount'] ?? 0);

        // إعطاء قيمة افتراضية للوصف إذا كان فارغاً
        $description = $validated['description'] ?? '';
        if (empty(trim($description))) {
            $typeDescriptions = [
                'course' => 'فاتورة كورس',
                'subscription' => 'فاتورة اشتراك',
                'membership' => 'فاتورة عضوية',
                'other' => 'فاتورة أخرى',
            ];
            $description = $typeDescriptions[$validated['type']] ?? 'فاتورة';
        }

        $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'description' => $description,
            'subtotal' => $validated['subtotal'],
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'total_amount' => $total,
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
