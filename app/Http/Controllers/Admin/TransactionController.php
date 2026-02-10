<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'payment', 'invoice', 'expense', 'subscription'])
            // إخفاء المعاملات المرتبطة بدفعات محذوفة
            // (payment_id = null ولكن metadata يحتوي على payment_id يعني أن الدفعة تم حذفها)
            ->where(function($q) {
                $q->whereNotNull('payment_id') // المعاملات المرتبطة بدفعات موجودة
                  ->orWhere(function($subQ) {
                      // المعاملات التي payment_id = null ولكن metadata لا يحتوي على payment_id
                      // (أي لم تكن مرتبطة بدفعة من الأساس)
                      $subQ->whereNull('payment_id')
                           ->where(function($metaQ) {
                               $metaQ->whereNull('metadata')
                                     ->orWhereRaw("JSON_EXTRACT(metadata, '$.payment_id') IS NULL");
                           });
                  });
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $type = $request->type;
            // تحويل القيم من الفلتر إلى القيم الفعلية في قاعدة البيانات
            $typeMapping = [
                'income' => 'credit',
                'expense' => 'debit',
                'transfer' => 'transfer',
                'refund' => 'refund',
            ];
            
            if (isset($typeMapping[$type])) {
                $query->where('type', $typeMapping[$type]);
            } else {
                $query->where('type', $type);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(20);

        $stats = [
            'total' => Transaction::count(),
            'total_amount' => Transaction::where('status', 'completed')->sum('amount'),
            'pending' => Transaction::where('status', 'pending')->count(),
            'completed' => Transaction::where('status', 'completed')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user', 'payment', 'invoice', 'expense', 'subscription', 'createdBy');
        return view('admin.transactions.show', compact('transaction'));
    }

    public function create()
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.transactions.create', compact('users'));
    }

    public function edit(Transaction $transaction)
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.transactions.edit', compact('transaction', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:credit,debit',
            'category' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'payment_id' => 'nullable|exists:payments,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'expense_id' => 'nullable|exists:expenses,id',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        Transaction::create([
            'transaction_number' => Transaction::generateTransactionNumber(),
            'user_id' => $validated['user_id'],
            'payment_id' => $validated['payment_id'] ?? null,
            'invoice_id' => $validated['invoice_id'] ?? null,
            'expense_id' => $validated['expense_id'] ?? null,
            'subscription_id' => $validated['subscription_id'] ?? null,
            'type' => $validated['type'],
            'category' => $validated['category'] ?? 'other',
            'amount' => $validated['amount'],
            'currency' => 'EGP',
            'description' => $validated['description'] ?? 'معاملة مالية',
            'status' => $validated['status'] ?? 'completed',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'تم إنشاء المعاملة بنجاح');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'description' => 'nullable|string',
        ]);

        $transaction->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'status' => $validated['status'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'تم تحديث المعاملة بنجاح');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
            ->with('success', 'تم حذف المعاملة بنجاح');
    }
}
