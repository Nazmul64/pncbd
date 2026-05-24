<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\HrmEmployee;
use App\Models\HrmAttendance;
use App\Models\HrmLeave;
use App\Models\HrmExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function manager_login()
    {
        if (Auth::check() && Auth::user()->load('roles')->isManager()) {
            return redirect()->route('manager.dashboard');
        }

        return view('manager.auth.login');
    }

    public function manager_login_submit(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // roles সহ user load করো
        $user = User::with('roles')->where('email', $request->email)->first();

        // User নেই
        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->withInput();
        }

        // Manager role নেই
        if (!$user->isManager()) {
            return back()->withErrors([
                'email' => 'Access denied. Manager account only.',
            ])->withInput();
        }

        // Account active নয়
        if (in_array($user->status, ['inactive', 'suspended', 'pending'])) {
            return back()->withErrors([
                'email' => 'Your account is not active. Contact administrator.',
            ])->withInput();
        }

        // Password check
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('manager.dashboard')
                ->with('success', 'Login successful. Welcome to the Manager panel!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function manager_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('manager.login')
            ->with('success', 'You have been logged out successfully.');
    }

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

    public function manager_dashboard()
    {
        $user = Auth::user();

        // Evaluate dynamic permissions
        $hasOrders = $user->isSuperAdmin() || $user->hasPermission('view-orders');
        $hasProducts = $user->isSuperAdmin() || $user->hasPermission('view-products');
        $hasHRM = $user->isSuperAdmin() || $user->hasAnyPermission([
            'view-employees', 'manage-attendance', 'manage-expenses', 'manage-salary-advance'
        ]);

        // E-Commerce Order Metrics (Only fetched if hasOrders is true)
        $ordersPending = 0;
        $ordersProcessing = 0;
        $ordersCompleted = 0;
        $salesLast30 = 0;
        $salesAllTime = 0;
        $recentOrders = collect();
        $chartLabels = [];
        $chartData = [];
        $statusCounts = [
            'all' => 0, 'pending' => 0, 'processing' => 0, 'completed' => 0, 'cancelled' => 0
        ];

        if ($hasOrders) {
            $ordersPending    = Order::where('order_status', 'pending')->count();
            $ordersProcessing = Order::where('order_status', 'processing')->count();
            $ordersCompleted  = Order::where('order_status', 'completed')->count();
            $salesLast30      = Order::where('order_status', 'completed')
                                    ->where('created_at', '>=', now()->subDays(30))
                                    ->count();
            $salesAllTime     = Order::where('order_status', 'completed')->count();
            $recentOrders     = Order::with('items')->latest()->take(5)->get();

            $salesChart = Order::where('order_status', 'completed')
                               ->where('created_at', '>=', now()->subDays(29)->startOfDay())
                               ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                               ->groupBy('date')
                               ->orderBy('date')
                               ->pluck('count', 'date');

            for ($i = 29; $i >= 0; $i--) {
                $date          = now()->subDays($i)->format('Y-m-d');
                $chartLabels[] = now()->subDays($i)->format('d M');
                $chartData[]   = $salesChart[$date] ?? 0;
            }

            $statusCounts = $this->getStatusCounts();
        }

        // E-Commerce Product Metrics (Only fetched if hasProducts is true)
        $totalProducts = 0;
        $popularProducts = collect();

        if ($hasProducts) {
            $totalProducts   = Product::count();
            $popularProducts = Product::withCount('orderItems')
                                      ->orderByDesc('order_items_count')
                                      ->take(5)
                                      ->get();
        }

        // HRM Metrics (Only fetched if hasHRM is true)
        $totalEmployees = 0;
        $attendanceToday = 0;
        $activeLeaves = 0;
        $expensesThisMonth = 0;

        if ($hasHRM) {
            $totalEmployees    = HrmEmployee::where('status', 'active')->count();
            $attendanceToday   = HrmAttendance::whereDate('date', today())->count();
            $activeLeaves      = HrmLeave::whereDate('start_date', '<=', today())
                                         ->whereDate('end_date', '>=', today())
                                         ->where('status', 'approved')
                                         ->count();
            $expensesThisMonth = HrmExpense::whereYear('date', today()->year)
                                           ->whereMonth('date', today()->month)
                                           ->sum('amount');
        }

        return view('manager.index', compact(
            'hasOrders', 'hasProducts', 'hasHRM',
            'ordersPending', 'ordersProcessing', 'ordersCompleted',
            'totalProducts', 'salesLast30', 'salesAllTime',
            'recentOrders', 'popularProducts',
            'chartLabels', 'chartData',
            'statusCounts',
            'totalEmployees', 'attendanceToday', 'activeLeaves', 'expensesThisMonth'
        ));
    }
}
