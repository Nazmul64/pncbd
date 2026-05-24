<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVisitLog extends Model
{
    protected $table = 'customer_visit_logs';

    protected $fillable = [
        'customer_visit_id',
        'ip_address',
        'user_agent',
        'page_name',
        'page_url',
        'visited_at',
        'is_alerted',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'is_alerted' => 'boolean',
    ];

    /**
     * Get the customer visit profile that owns this log.
     */
    public function customerVisit()
    {
        return $this->belongsTo(CustomerVisit::class, 'customer_visit_id', 'id');
    }
}
