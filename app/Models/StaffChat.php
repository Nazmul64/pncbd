<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffChat extends Model
{
    protected $fillable = [
        'staff_id',
        'last_activity_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(StaffChatMessage::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Staff-এর জন্য thread খুঁজো বা তৈরি করো।
     */
    public static function forStaff(int $staffId): self
    {
        return self::firstOrCreate(
            ['staff_id' => $staffId],
            ['last_activity_at' => now()]
        );
    }

    /**
     * Admin-এর কাছে কতটি অপঠিত message আছে (staff পাঠিয়েছে, admin পড়েনি)।
     */
    public function unreadForAdmin(): int
    {
        return $this->messages()
            ->where('sender_type', 'staff')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Staff-এর কাছে কতটি অপঠিত message আছে (admin পাঠিয়েছে, staff পড়েনি)।
     */
    public function unreadForStaff(): int
    {
        return $this->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->count();
    }
}
