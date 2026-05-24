<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatusHistory;
use App\Models\Ipblockmanage;
use App\Models\FraudApi;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AllorderController extends Controller
{
    // ── All Orders List ───────────────────────────────────────────
    public function allorder(Request $request)
    {
        $query = Order::with(['items', 'assignedStaff'])->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number',    'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone',         'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = Order::selectRaw("
            COUNT(*)                                AS all_count,
            SUM(order_status = 'pending')           AS pending,
            SUM(order_status = 'processing')        AS processing,
            SUM(order_status = 'shipped')           AS shipped,
            SUM(order_status = 'delivered')         AS delivered,
            SUM(order_status = 'cancelled')         AS cancelled
        ")->first();

        $statusCounts = [
            'all'        => (int) ($counts->all_count  ?? 0),
            'pending'    => (int) ($counts->pending    ?? 0),
            'processing' => (int) ($counts->processing ?? 0),
            'shipped'    => (int) ($counts->shipped    ?? 0),
            'delivered'  => (int) ($counts->delivered  ?? 0),
            'cancelled'  => (int) ($counts->cancelled  ?? 0),
        ];

        // Fetch all staff members (Admins, Managers, Employees)
        $staffMembers = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['super-admin', 'admin', 'manager', 'employee']);
        })->get(['id', 'name']);

        return view('admin.orders.index', compact('orders', 'statusCounts', 'staffMembers'));
    }

    // ── Order Details ─────────────────────────────────────────────
    public function show($id)
    {
        $order = Order::with(['items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // ── Update Order Status ───────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status,
        ]);

        // Record History
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'user_id'  => auth()->id(),
            'status'   => $request->order_status,
            'comment'  => 'Status updated to ' . $request->order_status,
        ]);

        return back()->with('success', 'অর্ডার স্ট্যাটাস সফলভাবে আপডেট হয়েছে।');
    }

    // ── Update Payment Status ─────────────────────────────────────
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        Order::findOrFail($id)->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'পেমেন্ট স্ট্যাটাস সফলভাবে আপডেট হয়েছে।');
    }

    // ── Staff Assignment Page (GET) ───────────────────────────────
    public function assignStaffPage($id)
    {
        $order = Order::findOrFail($id);
        $staffMembers = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['super-admin', 'admin', 'manager', 'employee']);
        })->get(['id', 'name']);

        return view('admin.orders.assign_staff', compact('order', 'staffMembers'));
    }

    // ── Assign Staff to Order (PATCH) ─────────────────────────────
    public function assignStaff(Request $request, $id)
    {
        $request->validate([
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'assigned_user_id' => $request->assigned_user_id,
        ]);

        return back()->with('success', 'স্টাফ সফলভাবে এসাইন করা হয়েছে।');
    }

    // ── Delete Single Order ───────────────────────────────────────
    public function destroy($id)
    {
        $order = Order::with(['items', 'steadfastOrder', 'pathaoOrder'])->findOrFail($id);
        
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $isSentToCourier = ($order->steadfastOrder && $order->steadfastOrder->is_sent) || $order->pathaoOrder;
            if ($order->order_status !== 'pending' || $isSentToCourier) {
                return redirect()->back()->with('error', 'এই অর্ডারটি কনফার্ম বা কুরিয়ারে পাঠানো হয়েছে, তাই আপনি এটি ডিলিট করতে পারবেন না।');
            }
        }

        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', 'অর্ডার সফলভাবে মুছে ফেলা হয়েছে।');
    }

    // ── Bulk Delete ───────────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:orders,id',
        ]);

        $orders = Order::whereIn('id', $request->ids)->with(['items', 'steadfastOrder', 'pathaoOrder'])->get();
        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            foreach ($orders as $order) {
                $isSentToCourier = ($order->steadfastOrder && $order->steadfastOrder->is_sent) || $order->pathaoOrder;
                if ($order->order_status !== 'pending' || $isSentToCourier) {
                    return redirect()->back()->with('error', 'সিলেক্ট করা অর্ডারগুলোর মধ্যে কনফার্ম হওয়া অর্ডার রয়েছে, যা আপনি ডিলিট করতে পারবেন না।');
                }
            }
        }

        foreach ($orders as $order) {
            $order->items()->delete();
            $order->delete();
        }

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', count($request->ids) . 'টি অর্ডার মুছে ফেলা হয়েছে।');
    }

    // ── Bulk Status Change ────────────────────────────────────────
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids'          => 'required|array|min:1',
            'ids.*'        => 'integer|exists:orders,id',
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $orders = Order::whereIn('id', $request->ids)->get();

        foreach($orders as $order) {
            $order->update(['order_status' => $request->order_status]);

            // Record History
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'user_id'  => auth()->id(),
                'status'   => $request->order_status,
                'comment'  => 'Bulk status update to ' . $request->order_status,
            ]);
        }

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', count($request->ids) . 'টি অর্ডারের স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ── Generate Invoice ──────────────────────────────────────────
    public function invoice(Request $request)
    {
        $ids = $request->ids;
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        if (!$ids || !is_array($ids)) {
            return back()->with('error', 'অর্ডার নির্বাচন করুন।');
        }

        $orders = Order::with(['items'])->whereIn('id', $ids)->get();
        $gs     = \App\Models\Generalsetting::first();

        return view('admin.orders.invoice', compact('orders', 'gs'));
    }

    // ── Toggle IP Block ──────────────────────────────────────────
    public function toggleIpBlock(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip',
        ]);

        $ip = $request->ip_address;
        $block = Ipblockmanage::where('ip_address', $ip)->first();

        if ($block) {
            $block->is_active = !$block->is_active;
            $block->save();
        } else {
            $block = Ipblockmanage::create([
                'ip_address' => $ip,
                'reason' => 'Manually blocked from Order list',
                'is_active' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'is_blocked' => $block->is_active,
            'message' => $block->is_active ? "IP Address {$ip} has been blocked." : "IP Address {$ip} has been unblocked."
        ]);
    }

    // ── Bulk Fraud Check (BDCourier API) ──────────────────────────
    public function bulkFraudCheck(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:orders,id',
        ]);

        $orders = Order::whereIn('id', $request->ids)->get(['id', 'phone']);
        $activeApi = FraudApi::where('is_active', true)->first();

        $results = [];

        foreach ($orders as $order) {
            $phone = preg_replace('/[^0-9]/', '', $order->phone);
            // standard Bangladeshi number has 11 digits, make sure it is in proper format
            if (strlen($phone) === 10) {
                $phone = '0' . $phone;
            } elseif (strlen($phone) > 11 && str_starts_with($phone, '880')) {
                $phone = substr($phone, 2);
            }

            $successRatio = 100;
            $fakeOrders = 0;
            $totalOrders = 1;

            if ($activeApi) {
                try {
                    $url = $activeApi->api_url;
                    $key = $activeApi->api_key;

                    $response = Http::timeout(5)->post($url, [
                        'phone' => $phone,
                        'api_key' => $key
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        // Handle standard BDCourier formats
                        if (isset($data['status']) && $data['status'] === 'success' && isset($data['courierData']['summary'])) {
                            $summary = $data['courierData']['summary'];
                            $successRatio = $summary['success_ratio'] ?? 100;
                            $fakeOrders = $summary['cancelled_parcel'] ?? 0;
                            $totalOrders = $summary['total_parcel'] ?? 1;
                        } else {
                            $successRatio = $data['success_ratio'] ?? ($data['success_rate'] ?? 100);
                            $fakeOrders = $data['fake_orders'] ?? ($data['cancelled'] ?? 0);
                            $totalOrders = $data['total_orders'] ?? ($data['total'] ?? 1);
                        }
                    } else {
                        // Fallback to local database calculations if API fails
                        $localOrders = Order::where('phone', $order->phone)->get();
                        $totalOrders = $localOrders->count();
                        if ($totalOrders > 0) {
                            $delivered = $localOrders->where('order_status', 'delivered')->count();
                            $successRatio = round(($delivered / $totalOrders) * 100);
                            $fakeOrders = $localOrders->whereIn('order_status', ['cancelled', 'returned'])->count();
                        }
                    }
                } catch (\Exception $e) {
                    // Fallback to local database calculations on exception
                    $localOrders = Order::where('phone', $order->phone)->get();
                    $totalOrders = $localOrders->count();
                    if ($totalOrders > 0) {
                        $delivered = $localOrders->where('order_status', 'delivered')->count();
                        $successRatio = round(($delivered / $totalOrders) * 100);
                        $fakeOrders = $localOrders->whereIn('order_status', ['cancelled', 'returned'])->count();
                    }
                }
            } else {
                // Fallback to local database calculations if no API configured
                $localOrders = Order::where('phone', $order->phone)->get();
                $totalOrders = $localOrders->count();
                if ($totalOrders > 0) {
                    $delivered = $localOrders->where('order_status', 'delivered')->count();
                    $successRatio = round(($delivered / $totalOrders) * 100);
                    $fakeOrders = $localOrders->whereIn('order_status', ['cancelled', 'returned'])->count();
                }
            }

            // Automatically block if they have high cancellations / fake orders
            if ($successRatio < 40 && $fakeOrders >= 1) {
                $profile = \App\Models\FraudProfile::firstOrNew(['phone' => $order->phone]);
                $profile->is_blocked = true;
                $profile->status = 'fake';
                $profile->blocked_at = now();
                
                // Set the IP from their last order if available
                $lastOrder = Order::where('phone', $order->phone)->whereNotNull('ip_address')->latest()->first();
                if ($lastOrder) {
                    $profile->ip_address = $lastOrder->ip_address;
                    
                    // Also automatically add to Ipblockmanage so that the IP block takes effect immediately
                    Ipblockmanage::updateOrCreate(
                        ['ip_address' => $lastOrder->ip_address],
                        [
                            'reason' => 'Automatically blocked due to fake order history (Phone: ' . $order->phone . ')',
                            'is_active' => true
                        ]
                    );
                }
                $profile->save();
            }

            $results[] = [
                'phone' => $order->phone,
                'success_ratio' => $successRatio,
                'fake_orders' => $fakeOrders,
                'total_orders' => $totalOrders
            ];
        }

        return response()->json([
            'status' => 'success',
            'results' => $results
        ]);
    }
}
