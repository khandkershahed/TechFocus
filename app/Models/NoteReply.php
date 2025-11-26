<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NoteReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'user_type',
        'reply',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUserNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name ?? $this->user->legal_name ?? 'Unknown User';
        }
        return 'Unknown User';
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->activity->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->activity->decrement('replies_count');
        });
    }
}