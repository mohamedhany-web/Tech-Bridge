<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with('user')
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($uq) use ($search) {
                $uq->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->paginate(18);

        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'expired' => Subscription::where('status', 'expired')->count(),
            'cancelled' => Subscription::where('status', 'cancelled')->count(),
            'auto_renew' => Subscription::where('auto_renew', true)->count(),
            'active_revenue' => (float) Subscription::where('status', 'active')->sum('price'),
        ];

        $currentMonthRange = [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ];

        $monthlyNew = Subscription::whereBetween('start_date', $currentMonthRange)->count();
        $monthlyRevenue = (float) Subscription::whereBetween('start_date', $currentMonthRange)->sum('price');

        $planDistribution = Subscription::selectRaw("COALESCE(NULLIF(subscription_type, ''), 'other') as subscription_type, COUNT(*) as subscriptions_count, SUM(price) as total_price")
            ->groupBy('subscription_type')
            ->get()
            ->map(function ($row) {
                $type = $row->subscription_type;
                return [
                    'type' => $type,
                    'label' => Subscription::typeLabel($type),
                    'subscriptions_count' => (int) $row->subscriptions_count,
                    'total_price' => (float) $row->total_price,
                ];
            });

        $expiringSoon = Subscription::with('user')
            ->where('status', 'active')
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [Carbon::now(), Carbon::now()->addDays(30)])
            ->orderBy('end_date')
            ->take(6)
            ->get();

        $recentSubscriptions = Subscription::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.subscriptions.index', compact(
            'subscriptions',
            'stats',
            'monthlyNew',
            'monthlyRevenue',
            'planDistribution',
            'expiringSoon',
            'recentSubscriptions'
        ));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['user', 'invoice', 'payments', 'transactions']);
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function create()
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.subscriptions.create', compact('users'));
    }

    public function edit(Subscription $subscription)
    {
        // جلب جميع المستخدمين النشطين (طلاب، مدربين، إلخ)
        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        // تحويل billing_cycle من عدد أشهر إلى نص للعرض في الـ select
        $monthsToCycle = [
            0.25 => 'weekly',
            1 => 'monthly',
            3 => 'quarterly',
            6 => 'biannual',
            12 => 'yearly',
        ];
        $billingCycleText = $monthsToCycle[$subscription->billing_cycle] ?? 'monthly';
        $subscription->billing_cycle = $billingCycleText;
        
        return view('admin.subscriptions.edit', compact('subscription', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_type' => 'required|string',
            'plan_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'auto_renew' => 'boolean',
            'billing_cycle' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // إنشاء Invoice تلقائياً للاشتراك
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'user_id' => $validated['user_id'],
                'type' => 'subscription',
                'description' => 'فاتورة اشتراك: ' . $validated['plan_name'],
                'subtotal' => $validated['price'],
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $validated['price'],
                'status' => 'pending',
                'due_date' => Carbon::parse($validated['start_date']),
                'notes' => 'فاتورة اشتراك - نوع: ' . Subscription::typeLabel($validated['subscription_type']),
                'items' => [
                    [
                        'description' => 'اشتراك: ' . $validated['plan_name'],
                        'quantity' => 1,
                        'price' => $validated['price'],
                        'total' => $validated['price'],
                    ]
                ],
            ]);

            // تحويل billing_cycle من نص إلى عدد أشهر
            $billingCycleMonths = [
                'weekly' => 0.25, // أسبوع = 0.25 شهر
                'monthly' => 1,
                'quarterly' => 3,
                'biannual' => 6,
                'yearly' => 12,
            ];
            $billingCycle = $billingCycleMonths[$validated['billing_cycle']] ?? 1;

            // إنشاء Subscription
            $subscription = Subscription::create([
                'user_id' => $validated['user_id'],
                'subscription_type' => $validated['subscription_type'],
                'plan_name' => $validated['plan_name'],
                'price' => $validated['price'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => 'active',
                'auto_renew' => $validated['auto_renew'] ?? false,
                'billing_cycle' => $billingCycle,
                'invoice_id' => $invoice->id,
            ]);

            DB::commit();

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'تم إنشاء الاشتراك والفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء إنشاء الاشتراك: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_type' => 'required|string',
            'plan_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,cancelled',
            'auto_renew' => 'boolean',
            'billing_cycle' => 'required|string',
        ]);

        // تحويل billing_cycle من نص إلى عدد أشهر
        $billingCycleMonths = [
            'weekly' => 0.25,
            'monthly' => 1,
            'quarterly' => 3,
            'biannual' => 6,
            'yearly' => 12,
        ];
        $validated['billing_cycle'] = $billingCycleMonths[$validated['billing_cycle']] ?? 1;

        $subscription->update($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم تحديث الاشتراك بنجاح');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم حذف الاشتراك بنجاح');
    }
}
