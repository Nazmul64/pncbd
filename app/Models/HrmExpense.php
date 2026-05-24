<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmExpense extends Model
{
    use HasFactory;

    protected $table = 'hrm_expenses';

    protected $fillable = [
        'title',
        'amount',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
