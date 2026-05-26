<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $table = 'user_informations';

    protected $fillable = [
        'user_id',
        'full_name',
        'nid_number',
        'phone_number',
        'occupation',
        'current_address',
        'permanent_address',
        'loan_reason',
        'selfie',
        'nid_front',
        'nid_back',
        'other_document',
        'stamp_contract',
        'signature',
        'nominee_name',
        'nominee_relation',
        'nominee_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
