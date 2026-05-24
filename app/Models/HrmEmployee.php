<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class HrmEmployee extends Model
{
    use HasFactory;

    protected $table = 'hrm_employees';

    protected $fillable = [
        'name',
        'phone',
        'nid_number',
        'employee_image',
        'nid_image',
        'father_name',
        'father_phone',
        'father_nid_image',
        'mother_name',
        'mother_phone',
        'mother_nid_number',
        'mother_nid_image',
        'parents_image',
        'address',
        'district',
        'thana',
        'salary',
        'status',
    ];

    /**
     * Get the attendances for this employee.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(HrmAttendance::class, 'employee_id');
    }

    /**
     * Get the salary advances for this employee.
     */
    public function salaryAdvances(): HasMany
    {
        return $this->hasMany(HrmSalaryAdvance::class, 'employee_id');
    }

    /**
     * Get the approved leaves for this employee.
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(HrmLeave::class, 'employee_id');
    }

    /**
     * Get the monthly payslips for this employee.
     */
    public function payslips(): HasMany
    {
        return $this->hasMany(HrmPayslip::class, 'employee_id');
    }

    /**
     * Calculate advance salary taken in a specific month & year.
     */
    public function getAdvanceAmountForMonth(int $year, int $month): float
    {
        return (float) $this->salaryAdvances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
    }

    /**
     * Calculate net payable salary for a specific month & year.
     */
    public function getNetPayableForMonth(int $year, int $month): float
    {
        $advance = $this->getAdvanceAmountForMonth($year, $month);
        return max(0.00, (float) $this->salary - $advance);
    }

    /**
     * Dynamic helper to return a fallback or actual uploaded image path.
     */
    public function getImageUrl(string $field): string
    {
        $value = $this->{$field};
        if ($value && file_exists(public_path($value))) {
            return asset($value);
        }

        if ($field === 'employee_image') {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=fff&size=200';
        }

        return asset('assets/backend/images/placeholder.jpg'); // or generic placeholder
    }
}
