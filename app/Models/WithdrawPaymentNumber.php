<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawPaymentNumber extends Model
{
    protected $fillable = [
        'group_name',
        'payment_method',
        'account_number',
        'account_holder',
        'pin',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * শুধুমাত্র active নম্বরগুলো — customer page-এ ব্যবহারের জন্য
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * payment_method-এর বাংলা লেবেল
     */
    public function getMethodLabelAttribute(): string
    {
        return match(strtolower($this->payment_method)) {
            'bkash'  => 'বিকাশ',
            'nagad'  => 'নগদ',
            'rocket' => 'রকেট',
            'bank'   => 'ব্যাংক',
            default  => $this->payment_method,
        };
    }

    /**
     * method badge color classes
     */
    public function getMethodColorAttribute(): string
    {
        return match(strtolower($this->payment_method)) {
            'bkash'  => 'bg-danger',
            'nagad'  => 'bg-warning text-dark',
            'rocket' => 'bg-purple',
            'bank'   => 'bg-primary',
            default  => 'bg-secondary',
        };
    }
}
