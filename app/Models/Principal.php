<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use Laravel\Sanctum\HasApiTokens;
use Wildside\Userstamps\Userstamps;
use Spatie\Ignition\Contracts\Solution;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PrincipalVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Principal extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug, Userstamps;

    protected $fillable = [
        'name',
        'username',
        'email',
        'code',
        'about',
        'photo',
        'support_tier',
        'support_tier_description',
        'phone',
        'address',
        'city',
        'postal',
        'last_seen',
        'company_name',
        'status',
        'email_verified_at',
        'password',
        'client_type',
        'company_phone_number',
        'company_logo',
        'company_url',
        'company_established_date',
        'company_address',
        'vat_number',
        'tax_number',
        'trade_license_number',
        'tin_number',
        'tin',
        'bin_certificate',
        'trade_license',
        'audit_paper',
        'industry_id_percentage',
        'product',
        'solution',
        'working_country',
        'yearly_revenue',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'contact_person_address',
        'contact_person_designation',
        'tier',
        'comments',
        'country_id',
        'created_by',
        'updated_by',
         'legal_name',
        'trading_name',
        'entity_type',
        'website_url',
        'country_iso',
        'hq_city',
        'relationship_status',
        'notes',
        'created_by',
        'archived_at',
    ];

    /**
     * Guarded attributes
     */
    protected $guarded = [];

    /**
     * Slug source column
     */
    protected $slugSourceColumn = 'name';

    /**
     * Fields hidden in arrays
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Fields cast
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new PrincipalVerifyEmail);
    }
    // In your Principal model
public function updateLastSeen()
{
    $this->update(['last_seen' => now()]);
}
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

public function contacts()
{
    return $this->hasMany(\App\Models\PrincipalContact::class, 'principal_id');
}

public function addresses()
{
    return $this->hasMany(\App\Models\PrincipalAddress::class, 'principal_id');
}

    /**
     * Check if principal is approved and active
     */
    public function isApproved()
    {
        return $this->status === 'active';
    }

    /**
     * Check if principal can login
     */
    public function canLogin()
    {
        return $this->isApproved() && $this->hasVerifiedEmail();
    }

  

    // public function brands()
    // {
    //     // Adjust 'principal_id' if your Brand model has a different foreign key
    //     return $this->hasMany(Brand::class, 'principal_id');
    // }

    // public function products()
    // {
    //     // Adjust 'principal_id' if your Product model has a different foreign key
    //     return $this->hasMany(Product::class, 'principal_id');
    // }
    // Principal.php
public function brands()
{
    return $this->hasMany(Brand::class);
}

public function products()
{
    return $this->hasMany(Product::class);
}

  public function links()
    {
        return $this->hasMany(PrincipalLink::class);
    }

  public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function shareLinks()
    {
        return $this->hasMany(ShareLink::class);
    }

    // Scope for user access
    public function scopeAccessibleBy($query, User $user)
    {
        if ($user->hasRole('SuperAdmin')) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            // Creator can always view their own records
            $q->where('creator_id', $user->id)
              ->orWhere('is_public', true);

            // Add scoped access for BrandAdmin and Viewer
            if ($user->hasRole('BrandAdmin') || $user->hasRole('Viewer')) {
                $scopes = $user->getAdminScopes();
                
                foreach ($scopes as $scopeType => $scopeIds) {
                    $q->orWhereIn("{$scopeType}_id", $scopeIds);
                }
            }
        });
    }
       public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the activities created by this principal.
     */
    public function createdActivities()
    {
        return $this->morphMany(Activity::class, 'created_by');
    }

    /**
     * Get the note replies for the principal.
     */
    public function noteReplies(): HasMany
    {
        return $this->hasMany(NoteReply::class, 'user_id')
            ->where('user_type', self::class);
    }


public function primaryContact()
{
    return $this->hasOne(PrincipalContact::class)->where('is_primary', true);
}

}