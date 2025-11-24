<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pinned' => 'boolean',
        'mentioned_users' => 'array',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Activity types
    const TYPE_NOTE = 'note';
    const TYPE_TASK = 'task';
    const TYPE_LINK_SHARED = 'link_shared';
    const TYPE_FILE_UPLOADED = 'file_uploaded';
    const TYPE_STATUS_CHANGED = 'status_changed';
    const TYPE_EDITED = 'edited';
    const TYPE_CREATED = 'created';

    // Related types
    const RELATED_BRAND = 'brand';
    const RELATED_PRODUCT = 'product';
    const RELATED_CONTRACT = 'contract';
    const RELATED_USER = 'user';

    /**
     * Get the principal that owns the activity.
     */
    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class);
    }

    /**
     * Get the model that created the activity.
     */
    public function createdBy(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the related model.
     */
    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the users mentioned in this activity.
     */
    public function mentions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activity_mentions')
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include pinned activities.
     */
    public function scopePinned($query)
    {
        return $query->where('pinned', true);
    }

    /**
     * Scope a query to only include activities of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include recent activities.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if the activity is pinned.
     */
    public function isPinned(): bool
    {
        return $this->pinned;
    }

    /**
     * Check if the activity has mentions.
     */
    public function hasMentions(): bool
    {
        return !empty($this->mentioned_users);
    }

    /**
     * Get the activity icon based on type.
     */
    public function getIconAttribute(): string
    {
        $icons = [
            self::TYPE_NOTE => 'fa-note-sticky',
            self::TYPE_TASK => 'fa-square-check',
            self::TYPE_LINK_SHARED => 'fa-link',
            self::TYPE_FILE_UPLOADED => 'fa-file',
            self::TYPE_STATUS_CHANGED => 'fa-flag',
            self::TYPE_EDITED => 'fa-pen',
            self::TYPE_CREATED => 'fa-plus',
        ];

        return $icons[$this->type] ?? 'fa-circle';
    }

    /**
     * Get the activity color class based on type.
     */
    public function getColorClassAttribute(): string
    {
        $colors = [
            self::TYPE_NOTE => 'blue',
            self::TYPE_TASK => 'green',
            self::TYPE_LINK_SHARED => 'purple',
            self::TYPE_FILE_UPLOADED => 'orange',
            self::TYPE_STATUS_CHANGED => 'yellow',
            self::TYPE_EDITED => 'indigo',
            self::TYPE_CREATED => 'green',
        ];

        return $colors[$this->type] ?? 'gray';
    }

    /**
     * Get the activity badge color for Tailwind CSS.
     */
    public function getBadgeColorAttribute(): array
    {
        $colors = [
            self::TYPE_NOTE => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            self::TYPE_TASK => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            self::TYPE_LINK_SHARED => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
            self::TYPE_FILE_UPLOADED => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
            self::TYPE_STATUS_CHANGED => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            self::TYPE_EDITED => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
            self::TYPE_CREATED => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
        ];

        return $colors[$this->type] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
    }

    /**
     * Create a new activity record.
     */
    public static function createActivity(array $data): self
    {
        return self::create([
            'principal_id' => $data['principal_id'],
            'type' => $data['type'] ?? self::TYPE_NOTE,
            'subtype' => $data['subtype'] ?? null,
            'description' => $data['description'],
            'rich_content' => $data['rich_content'] ?? $data['description'],
            'created_by_id' => $data['created_by_id'],
            'created_by_type' => $data['created_by_type'],
            'pinned' => $data['pinned'] ?? false,
            'mentioned_users' => $data['mentioned_users'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'related_type' => $data['related_type'] ?? null,
            'related_id' => $data['related_id'] ?? null,
        ]);
    }

    /**
     * Add mentions to the activity.
     */
    public function addMentions(array $userIds): void
    {
        $this->mentions()->sync($userIds);
        $this->update(['mentioned_users' => $userIds]);
    }

    /**
     * Pin the activity.
     */
    public function pin(): void
    {
        $this->update(['pinned' => true]);
    }

    /**
     * Unpin the activity.
     */
    public function unpin(): void
    {
        $this->update(['pinned' => false]);
    }
}