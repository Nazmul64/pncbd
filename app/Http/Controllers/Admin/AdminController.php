<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ─────────────────────────────────────────────
    //  Shared: statusCounts helper (kept for order pages)
    // ─────────────────────────────────────────────
    private function getStatusCounts(): array
    {
        return [
            'all'        => Order::count(),
            'pending'    => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'completed'  => Order::where('order_status', 'completed')->count(),
            'cancelled'  => Order::where('order_status', 'cancelled')->count(),
        ];
    }

    // ─────────────────────────────────────────────
    //  Dashboard — LOAN MANAGEMENT FOCUSED
    // ─────────────────────────────────────────────
    public function admin_dashboard()
    {
        $user = auth()->user();

        // ── LOAN STATISTICS ──────────────────────────────────────────────
        $totalLoans       = Loan::count();
        $pendingLoans     = Loan::where('status', 'pending')->count();
        $approvedLoans    = Loan::where('status', 'approved')->count();
        $rejectedLoans    = Loan::where('status', 'rejected')->count();

        $totalAmountApplied  = Loan::sum('amount');
        $totalAmountApproved = Loan::where('status', 'approved')->sum('amount');
        $totalPayableAmount  = Loan::where('status', 'approved')->sum('total_payable');
        $totalInterestAmount = Loan::where('status', 'approved')->sum('interest_amount');

        // ── TODAY / 7 DAYS / 30 DAYS ─────────────────────────────────────
        $loansToday   = Loan::whereDate('created_at', today())->count();
        $loans7Days   = Loan::where('created_at', '>=', now()->subDays(7))->count();
        $loans30Days  = Loan::where('created_at', '>=', now()->subDays(30))->count();

        $amountToday  = Loan::whereDate('created_at', today())->sum('amount');
        $amount7Days  = Loan::where('created_at', '>=', now()->subDays(7))->sum('amount');
        $amount30Days = Loan::where('created_at', '>=', now()->subDays(30))->sum('amount');

        // ── RECENT LOAN APPLICATIONS (last 10) ──────────────────────────
        $recentLoans = Loan::with('user', 'bank')->latest()->take(10)->get();

        // ── 30-DAY APPLICATION TREND CHART ──────────────────────────────
        $loanChart = Loan::where('created_at', '>=', now()->subDays(29)->startOfDay())
                         ->selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(amount) as amount')
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get()
                         ->keyBy('date');

        $chartLabels = [];
        $chartCountData = [];
        $chartAmountData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $chartCountData[] = (int) ($loanChart[$date]->total ?? 0);
            $chartAmountData[] = (float) ($loanChart[$date]->amount ?? 0);
        }

        // ── REGISTERED USERS & KYC ─────────────────────────────────────
        $totalRegisteredUsers = Customer::count();
        $totalKycSubmitted    = UserInformation::count();

        // ── LOAN STATUS BREAKDOWN BY PAYMENT METHOD ─────────────────────
        $methodStats = Loan::selectRaw("payment_method, COUNT(*) as total, SUM(amount) as amount")
                           ->groupBy('payment_method')
                           ->get();

        // ── HRM Metrics (kept but secondary) ────────────────────────────
        $hasHRM = $user->isSuperAdmin() || $user->hasAnyPermission([
            'view-employees', 'manage-attendance', 'manage-expenses', 'manage-salary-advance'
        ]);

        $totalEmployees = 0;
        $attendanceToday = 0;
        $activeLeaves = 0;
        $expensesThisMonth = 0;

        if ($hasHRM) {
            $totalEmployees    = \App\Models\HrmEmployee::where('status', 'active')->count();
            $attendanceToday   = \App\Models\HrmAttendance::whereDate('date', today())->count();
            $activeLeaves      = \App\Models\HrmLeave::whereDate('start_date', '<=', today())
                                         ->whereDate('end_date', '>=', today())
                                         ->where('status', 'approved')
                                         ->count();
            $expensesThisMonth = \App\Models\HrmExpense::whereYear('date', today()->year)
                                           ->whereMonth('date', today()->month)
                                           ->sum('amount');
        }

        return view('admin.index', compact(
            'totalLoans', 'pendingLoans', 'approvedLoans', 'rejectedLoans',
            'totalAmountApplied', 'totalAmountApproved', 'totalPayableAmount', 'totalInterestAmount',
            'loansToday', 'loans7Days', 'loans30Days',
            'amountToday', 'amount7Days', 'amount30Days',
            'recentLoans',
            'chartLabels', 'chartCountData', 'chartAmountData',
            'totalRegisteredUsers', 'totalKycSubmitted',
            'methodStats',
            'hasHRM', 'totalEmployees', 'attendanceToday', 'activeLeaves', 'expensesThisMonth'
        ));
    }

    // ─────────────────────────────────────────────
    //  All Orders
    // ─────────────────────────────────────────────
    public function all_order(Request $request)
    {
        $query = Order::with('items')->latest();

        // Status filter
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders       = $query->paginate(15);
        $statusCounts = $this->getStatusCounts();
        // Staff = users who have manager or employee role (can handle orders)
        $staffUsers   = User::whereHas('roles', fn($q) => $q->whereIn('slug', ['manager','employee','admin','super-admin']))
                            ->where('status', 'active')->get(['id','name']);

        if (request()->routeIs('manager.*')) {
            return view('manager.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
        } elseif (request()->routeIs('emplee.*')) {
            return view('emplee.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
        }

        return view('admin.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
    }

    // ─────────────────────────────────────────────
    //  Order Detail
    // ─────────────────────────────────────────────
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // ─────────────────────────────────────────────
    //  Update Order Status
    // ─────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return back()->with('success', 'অর্ডার স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Update Payment Status
    // ─────────────────────────────────────────────
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'পেমেন্ট স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Delete Order
    // ─────────────────────────────────────────────
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'অর্ডারটি মুছে ফেলা হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Assign Staff to Order
    // ─────────────────────────────────────────────
    public function assignStaff(Request $request, $id)
    {
        $request->validate([
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['assigned_user_id' => $request->assigned_user_id ?: null]);

        return back()->with('success', 'স্টাফ অ্যাসাইন আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Bulk Delete Orders
    // ─────────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'order_ids'   => 'required|array',
            'order_ids.*' => 'exists:orders,id',
        ]);

        Order::whereIn('id', $request->order_ids)->delete();

        return back()->with('success', count($request->order_ids) . 'টি অর্ডার মুছে ফেলা হয়েছে।');
    }
}
