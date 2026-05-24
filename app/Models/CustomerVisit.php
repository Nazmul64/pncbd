<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    protected $fillable = [
        'tracking_id',
        'phone',
        'customer_name',
        'ip_address',
        'user_agent',
        'visit_count',
        'last_visited_at',
    ];

    protected $casts = [
        'last_visited_at' => 'datetime',
        'visit_count'     => 'integer',
    ];

    /**
     * Relationship to retrieve all past orders placed by this customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'phone', 'phone')->latest();
    }

    /**
     * Convenience relationship to get the absolute latest order of this customer.
     */
    public function latestOrder()
    {
        return $this->hasOne(Order::class, 'phone', 'phone')->latestOfMany();
    }

    /**
     * Relationship to retrieve all unique visit logs for this customer.
     */
    public function visitLogs()
    {
        return $this->hasMany(CustomerVisitLog::class, 'customer_visit_id', 'id')->latest();
    }

    /**
     * Automatically log/update customer tracking details upon order placement
     * and queue a tracking cookie in the browser.
     */
    public static function logOrderVisit($phone, $customerName)
    {
        $cookieName = '_habibi_tracker_id';
        $trackingId = request()->cookie($cookieName);

        // Find existing record by phone
        $visit = self::where('phone', $phone)->first();

        if ($visit) {
            // Keep existing tracking_id or get from cookie
            $trackingId = $visit->tracking_id ?? $trackingId ?? (string) \Illuminate\Support\Str::uuid();
        } else {
            // New record, get tracking_id from cookie or generate new
            $trackingId = $trackingId ?? (string) \Illuminate\Support\Str::uuid();
        }

        // Upsert record
        $visit = self::updateOrCreate(
            ['phone' => $phone],
            [
                'tracking_id'     => $trackingId,
                'customer_name'   => $customerName,
                'ip_address'      => request()->ip(),
                'user_agent'      => request()->userAgent(),
                'last_visited_at' => now(),
            ]
        );

        // Create a new visit history log for this order placement visit
        \App\Models\CustomerVisitLog::create([
            'customer_visit_id' => $visit->id,
            'ip_address'        => request()->ip(),
            'user_agent'        => request()->userAgent(),
            'page_name'         => '✅ অর্ডার সম্পূর্ণ পেজ',
            'page_url'          => request()->fullUrl(),
            'visited_at'        => now(),
            'is_alerted'        => false,
        ]);

        // Queue the cookie to keep it persistent for 1 year
        \Illuminate\Support\Facades\Cookie::queue($cookieName, $trackingId, 60 * 24 * 365);

        return $visit;
    }
}
