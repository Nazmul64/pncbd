<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrmSalaryAdvance extends Model
{
    use HasFactory;

    protected $table = 'hrm_salary_advances';

    protected $fillable = [
        'employee_id',
        'amount',
        'date',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the employee associated with this salary advance record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrmEmployee::class, 'employee_id');
    }
}
