<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffChatMessage extends Model
{
    protected $fillable = [
        'staff_chat_id',
        'sender_type',
        'sender_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function chat(): BelongsTo
    {
        return $this->belongsTo(StaffChat::class, 'staff_chat_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
