<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'type',
        'subtype',
        'description',
        'rich_content',
        'created_by_id',
        'created_by_type',
        'pinned',
        'mentioned_users',
        'metadata',
        'related_type',
        'related_id',
        'replies_count'
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'mentioned_users' => 'array',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the principal that owns the activity.
     */
    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class);
    }

    /**
     * Get the user that created the activity.
     */
    public function createdBy(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the replies for the activity.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(NoteReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest reply
     */
    public function latestReply()
    {
        return $this->hasOne(NoteReply::class)->latest();
    }

    /**
     * Check if activity has attachments
     */
    public function hasAttachments(): bool
    {
        return !empty($this->metadata['attachments']);
    }

    /**
     * Get attachments array
     */
    public function getAttachmentsAttribute(): array
    {
        return $this->metadata['attachments'] ?? [];
    }
    
}