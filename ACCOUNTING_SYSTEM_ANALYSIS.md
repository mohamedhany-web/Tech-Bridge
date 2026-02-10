# تحليل نظام المحاسبة - Accounting System Analysis

## 📊 **المكونات الحالية:**

### 1. **Orders (الطلبات)**
- ✅ ربط بـ Invoice و Payment
- ✅ ربط بـ Wallet
- ✅ عند الموافقة: ينشئ Invoice → Payment → Transaction (credit)

### 2. **Invoices (الفواتير)**
- ✅ hasMany Payments
- ✅ hasMany Transactions (مفقود - يحتاج ربط)
- ✅ hasOne Order
- ✅ hasMany Enrollments
- ✅ hasMany Subscriptions

### 3. **Payments (المدفوعات)**
- ✅ belongsTo Invoice
- ✅ hasMany Transactions (مفقود - يحتاج ربط)
- ❌ ربط بـ Wallet (مفقود - عند استخدام المحفظة)
- ❌ ربط بـ InstallmentPayment (مفقود)

### 4. **Transactions (المعاملات المالية)**
- ✅ belongsTo Payment
- ❌ ربط بـ Invoice (مفقود - للربط المباشر)
- ❌ ربط بـ Expense (مفقود)
- ❌ ربط بـ Subscription (مفقود)

### 5. **Expenses (المصروفات)**
- ✅ belongsTo Wallet
- ❌ ربط بـ Transaction (مفقود - عند الموافقة)
- ❌ ربط بـ Invoice (مفقود - إذا كان هناك فاتورة للمصروف)

### 6. **Wallets (المحافظ)**
- ✅ hasMany WalletTransactions
- ❌ ربط بـ Payments (مفقود)

### 7. **Subscriptions (الاشتراكات)**
- ✅ belongsTo Invoice
- ❌ ربط بـ Payments (مفقود)
- ❌ ربط بـ Transactions (مفقود)

### 8. **InstallmentPayments (مدفوعات التقسيط)**
- ✅ belongsTo InstallmentAgreement
- ✅ belongsTo Payment
- ❌ ربط بـ Transaction (مفقود)

## 🔗 **التحسينات المطلوبة:**

### 1. **إضافة أعمدة للربط:**
- `transactions.invoice_id` - ربط المعاملات بالفوترة مباشرة
- `transactions.expense_id` - ربط المعاملات بالمصروفات
- `transactions.subscription_id` - ربط المعاملات بالاشتراكات
- `payments.wallet_id` - ربط المدفوعات بالمحافظ
- `payments.installment_payment_id` - ربط المدفوعات بمدفوعات التقسيط
- `expenses.transaction_id` - ربط المصروفات بالمعاملات
- `expenses.invoice_id` - ربط المصروفات بالفواتير (اختياري)

### 2. **إضافة علاقات Models:**
- Payment → hasMany Transactions
- Payment → belongsTo Wallet
- Transaction → belongsTo Invoice
- Transaction → belongsTo Expense
- Transaction → belongsTo Subscription
- Expense → belongsTo Transaction
- Expense → belongsTo Invoice (اختياري)
- Subscription → hasMany Payments
- Subscription → hasMany Transactions

### 3. **تحسين التدفق:**
- عند الموافقة على Order: Order → Invoice → Payment → Transaction (credit)
- عند الموافقة على Expense: Expense → Transaction (debit)
- عند الدفع من Wallet: Payment → Wallet → WalletTransaction
- عند دفع Installment: InstallmentPayment → Payment → Transaction

## 🎯 **الترابط الكامل المقترح:**

```
Order (طلب)
  ↓
Invoice (فاتورة)
  ↓
Payment (دفعة)
  ├─→ Transaction (credit - إيراد)
  ├─→ Wallet (إذا دفع من المحفظة)
  └─→ InstallmentPayment (إذا كان تقسيط)
      └─→ Transaction (credit - إيراد)

Expense (مصروف)
  ↓
Transaction (debit - مصروف)
  └─→ Wallet (إذا دفع من المحفظة)

Subscription (اشتراك)
  ↓
Invoice (فاتورة)
  ↓
Payment (دفعات دورية)
  └─→ Transaction (credit - إيراد)
```

