<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrmPayslip extends Model
{
    use HasFactory;

    protected $table = 'hrm_payslips';

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'present_days',
        'absent_days',
        'leave_days',
        'advances_drawn',
        'bonus',
        'deductions',
        'net_salary',
        'status',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrmEmployee::class, 'employee_id');
    }
}
