<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'payment_method',
        'account_holder_name',
        'account_number',
        'branch',
        'amount',
        'tenure',
        'interest_rate',
        'interest_amount',
        'total_payable',
        'monthly_installment',
        'status',
        'admin_message',
        'screenshot',
        'admin_fee',
        'staff_name',
        'staff_phone',
        'signature_image',
    ];

    /**
     * Get the user that owns the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bank associated with the loan.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
