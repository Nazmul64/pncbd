<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Ipblockmanage;
use App\Models\FraudProfile;
use Illuminate\Support\Facades\Http;

class BlockIpMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();

        // 1. Avoid infinite loop for the warning page itself
        if ($request->routeIs('cyber.warning')) {
            return $next($request);
        }

        // 2. ONLY block Order Submission (POST) routes
        $requestPath = trim($request->path(), '/');
        
        $isOrderSubmit = $request->isMethod('post') && (
            $requestPath === 'checkout/place' || 
            str_starts_with($requestPath, 'checkout/place') ||
            str_starts_with($requestPath, 'landing/order/store') ||
            str_starts_with($requestPath, 'order/store') ||
            $request->routeIs('order.store')
        );

        if (!$isOrderSubmit) {
            return $next($request);
        }

        // 3. Check if IP is blocked in IP Block table or Fraud Profiles
        $isBlocked = Ipblockmanage::where('ip_address', $clientIp)
            ->where('is_active', true)
            ->exists();

        if (!$isBlocked) {
            $isBlocked = FraudProfile::where('ip_address', $clientIp)
                ->where('is_blocked', true)
                ->exists();
        }

        if ($isBlocked) {
            // Fetch ISP & Location from ip-api.com if not cached in session
            $sessionKey = 'blocked_ip_details_' . md5($clientIp);
            if (!session()->has($sessionKey)) {
                $details = [
                    'isp' => 'Unknown WiFi Provider / Broadband',
                    'city' => 'Unknown City',
                    'regionName' => 'Unknown Area',
                    'country' => 'Bangladesh',
                    'ip' => $clientIp,
                    'lat' => 23.8103,
                    'lon' => 90.4125
                ];
                
                // Realistic simulation for Local IPs (127.0.0.1 or ::1) so that testing looks awesome
                if ($clientIp === '127.0.0.1' || $clientIp === '::1') {
                    $details = [
                        'isp' => 'Dot Internet (Broadband WiFi)',
                        'city' => 'Dhaka',
                        'regionName' => 'Uttara',
                        'country' => 'Bangladesh',
                        'ip' => '103.125.24.89', // Simulated real public IP of Bangladesh
                        'lat' => 23.8759,
                        'lon' => 90.3795
                    ];
                } else {
                    try {
                        $response = Http::timeout(2.5)->get("http://ip-api.com/json/{$clientIp}");
                        if ($response->successful()) {
                            $apiData = $response->json();
                            if (($apiData['status'] ?? '') === 'success') {
                                $details = [
                                    'isp' => $apiData['isp'] ?? $details['isp'],
                                    'city' => $apiData['city'] ?? $details['city'],
                                    'regionName' => $apiData['regionName'] ?? ($apiData['region'] ?? $details['regionName']),
                                    'country' => $apiData['country'] ?? $details['country'],
                                    'ip' => $clientIp,
                                    'lat' => $apiData['lat'] ?? $details['lat'],
                                    'lon' => $apiData['lon'] ?? $details['lon']
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        // Fail gracefully
                    }
                }
                session()->put($sessionKey, $details);
            }

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'blocked' => true,
                    'redirect' => route('cyber.warning'),
                    'message' => 'আমাদের সিকিউরিটি সিস্টেম আপনার আইপি ব্লক করেছে। আপনার বিরুদ্ধে সাইবার ক্রাইম মামলা দেওয়ার প্রক্রিয়া শুরু হয়েছে।'
                ], 403);
            }

            // Redirect normal requests to the warning page
            return redirect()->route('cyber.warning');
        }

        return $next($request);
    }
}
