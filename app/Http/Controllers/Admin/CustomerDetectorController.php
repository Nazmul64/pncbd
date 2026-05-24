<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerVisit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerDetectorController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\CustomerVisitLog::query()
            ->join('customer_visits', 'customer_visit_logs.customer_visit_id', '=', 'customer_visits.id')
            ->whereNotNull('customer_visits.phone')
            ->select('customer_visit_logs.*');

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('customer_visit_logs.visited_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('customer_visit_logs.visited_at', '<=', $request->end_date);
        }

        // Filter by Day of Week (In MySQL, 1 = Sunday, 2 = Monday, ..., 7 = Saturday)
        if ($request->filled('day_of_week')) {
            $query->whereRaw('DAYOFWEEK(customer_visit_logs.visited_at) = ?', [$request->day_of_week]);
        }

        // Filter by Period (Day vs Night)
        // Day: 06:00 AM - 05:59 PM (Hour 6 to 17)
        // Night: 06:00 PM - 05:59 AM (Hour >= 18 or < 6)
        if ($request->filled('period')) {
            if ($request->period === 'day') {
                $query->whereRaw('HOUR(customer_visit_logs.visited_at) >= 6 AND HOUR(customer_visit_logs.visited_at) < 18');
            } elseif ($request->period === 'night') {
                $query->whereRaw('(HOUR(customer_visit_logs.visited_at) < 6 OR HOUR(customer_visit_logs.visited_at) >= 18)');
            }
        }

        // Filter by Hour of Day (0-23)
        if ($request->filled('hour')) {
            $query->whereRaw('HOUR(customer_visit_logs.visited_at) = ?', [$request->hour]);
        }

        // Get returning customers logs sorted by their most recent active visit log
        $visits = $query->with(['customerVisit.latestOrder.items'])
            ->orderBy('customer_visit_logs.visited_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // 📊 Premium Analytics Metrics Calculations
        $todayStart = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);
        $thirtyDaysAgo = Carbon::today()->subDays(29);

        // Calculate counts
        $todayVisitsCount = \App\Models\CustomerVisitLog::whereDate('visited_at', $todayStart)->count();
        $sevenDaysVisitsCount = \App\Models\CustomerVisitLog::where('visited_at', '>=', $sevenDaysAgo)->count();
        $thirtyDaysVisitsCount = \App\Models\CustomerVisitLog::where('visited_at', '>=', $thirtyDaysAgo)->count();

        // Calculate page breakdown today
        $todayPageBreakdown = \App\Models\CustomerVisitLog::whereDate('visited_at', $todayStart)
            ->selectRaw('page_name, count(*) as count')
            ->groupBy('page_name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        return view('admin.customer_detector.index', compact(
            'visits', 
            'todayVisitsCount', 
            'sevenDaysVisitsCount', 
            'thirtyDaysVisitsCount', 
            'todayPageBreakdown'
        ));
    }

    public function pollNewVisits()
    {
        // 1. Fetch new unread visit logs (alerts)
        $newLogs = \App\Models\CustomerVisitLog::where('is_alerted', false)
            ->with(['customerVisit.latestOrder'])
            ->get();

        $alerts = [];
        if ($newLogs->count() > 0) {
            // Mark these logs as alerted
            \App\Models\CustomerVisitLog::whereIn('id', $newLogs->pluck('id'))->update(['is_alerted' => true]);

            foreach ($newLogs as $log) {
                $visit = $log->customerVisit;
                if (!$visit) continue;
                $latestOrder = $visit->latestOrder;

                $alerts[] = [
                    'id'            => $log->id,
                    'phone'         => $visit->phone,
                    'name'          => $visit->customer_name ?? ($latestOrder ? $latestOrder->customer_name : 'Unknown Customer'),
                    'page_name'     => $log->page_name ?? '📄 অন্যান্য পেজ',
                    'visited_at'    => $log->visited_at->translatedFormat('h:i A'),
                    'time_ago'      => $log->visited_at->diffForHumans(),
                    'order_total'   => $latestOrder ? $latestOrder->total : 0,
                ];
            }
        }

        // 2. Fetch the 10 most recent visit logs to populate the topbar bell dropdown
        $recentLogs = \App\Models\CustomerVisitLog::with(['customerVisit.latestOrder'])
            ->join('customer_visits', 'customer_visit_logs.customer_visit_id', '=', 'customer_visits.id')
            ->whereNotNull('customer_visits.phone')
            ->orderBy('customer_visit_logs.visited_at', 'desc')
            ->select('customer_visit_logs.*')
            ->limit(10)
            ->get();

        $recentList = [];
        foreach ($recentLogs as $log) {
            $visit = $log->customerVisit;
            if (!$visit) continue;
            $latestOrder = $visit->latestOrder;

            $recentList[] = [
                'id'            => $log->id,
                'phone'         => $visit->phone,
                'name'          => $visit->customer_name ?? ($latestOrder ? $latestOrder->customer_name : 'Unknown Customer'),
                'page_name'     => $log->page_name ?? '📄 অন্যান্য পেজ',
                'time_ago'      => $log->visited_at->diffForHumans(),
                'visited_at'    => $log->visited_at->translatedFormat('l, h:i A'),
            ];
        }

        // Count of total alerts in the database that are unread
        $unreadCount = \App\Models\CustomerVisitLog::where('is_alerted', false)->count();

        return response()->json([
            'success'     => true,
            'alerts'      => $alerts,
            'recent_list' => $recentList,
            'unread_count'=> $unreadCount,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
        ]);

        \App\Models\CustomerVisitLog::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . 'টি কাস্টমার ভিজিট হিস্ট্রি মুছে ফেলা হয়েছে।');
    }
}
