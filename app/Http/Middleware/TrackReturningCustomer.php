<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CustomerVisit;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

class TrackReturningCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for Admin panel, API endpoints, or AJAX files to prevent database congestion
        if ($request->is('admin*') || $request->is('api*') || $request->ajax()) {
            return $next($request);
        }

        $cookieName = '_habibi_tracker_id';
        $trackingId = $request->cookie($cookieName);
        $customerVisit = null;

        if ($trackingId) {
            // Find by tracking ID
            $customerVisit = CustomerVisit::where('tracking_id', $trackingId)->first();
        } else {
            // Fallback: search by same IP and user agent
            $ip = $request->ip();
            $ua = $request->userAgent();

            if ($ip && $ua) {
                $customerVisit = CustomerVisit::where('ip_address', $ip)
                    ->where('user_agent', $ua)
                    ->whereNotNull('phone')
                    ->first();

                // If found, restore the cookie to the user's browser
                if ($customerVisit && $customerVisit->tracking_id) {
                    Cookie::queue($cookieName, $customerVisit->tracking_id, 60 * 24 * 365);
                }
            }
        }

        // If we identified a registered returning customer, update their visit log
        if ($customerVisit) {
            $now = Carbon::now();
            $customerVisit->update([
                'last_visited_at' => $now,
                'visit_count'     => $customerVisit->visit_count + 1,
                'ip_address'      => $request->ip(),
                'user_agent'      => $request->userAgent(),
            ]);

            // 🧠 Smart Page Detection & Dynamic Formatting
            $path = $request->path();
            $pageUrl = $request->fullUrl();
            $pageName = '📄 অন্যান্য পেজ';

            if ($path === '/' || $path === '') {
                $pageName = '🏠 হোম পেজ';
            } elseif (strpos($path, 'checkout') !== false) {
                $pageName = '🛒 চেকআউট পেজ';
            } elseif (strpos($path, 'cart') !== false) {
                $pageName = '🛍️ কার্ট পেজ';
            } elseif (strpos($path, 'product') !== false) {
                $segments = explode('/', $path);
                $slug = end($segments);
                if ($slug && $slug !== 'product') {
                    $pageName = '📦 প্রোডাক্ট: ' . ucwords(str_replace(['-', '_'], [' ', ' '], $slug));
                } else {
                    $pageName = '📦 প্রোডাক্ট পেজ';
                }
            } elseif (strpos($path, 'shop') !== false) {
                $pageName = '🏪 শপ পেজ';
            } elseif (strpos($path, 'category') !== false) {
                $segments = explode('/', $path);
                $slug = end($segments);
                if ($slug && $slug !== 'category') {
                    $pageName = '🏷️ ক্যাটাগরি: ' . ucwords(str_replace(['-', '_'], [' ', ' '], $slug));
                } else {
                    $pageName = '🏷️ ক্যাটাগরি পেজ';
                }
            } else {
                $pageName = '📄 ' . ucwords(str_replace(['/', '-', '_'], [' ', ' ', ' '], $path));
            }

            // Check the last recorded log for this customer
            $lastLog = \App\Models\CustomerVisitLog::where('customer_visit_id', $customerVisit->id)
                ->orderBy('id', 'desc')
                ->first();

            // Record a new log if:
            // 1. There is no last log
            // 2. The customer has transitioned to a different page/url
            // 3. The customer is on the same page but it was more than 5 minutes ago (e.g. refreshed or returned)
            $shouldLog = !$lastLog 
                || ($lastLog->page_url !== $pageUrl) 
                || ($lastLog->visited_at->lt($now->copy()->subMinutes(5)));

            if ($shouldLog) {
                \App\Models\CustomerVisitLog::create([
                    'customer_visit_id' => $customerVisit->id,
                    'ip_address'        => $request->ip(),
                    'user_agent'        => $request->userAgent(),
                    'page_name'         => $pageName,
                    'page_url'          => $pageUrl,
                    'visited_at'        => $now,
                    'is_alerted'        => false,
                ]);
            }
        }

        return $next($request);
    }
}
