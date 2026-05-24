<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrmAttendance extends Model
{
    use HasFactory;

    protected $table = 'hrm_attendances';

    protected $fillable = [
        'employee_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the employee associated with this attendance record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrmEmployee::class, 'employee_id');
    }
}
