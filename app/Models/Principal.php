<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\PrincipalVerifyEmail;
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


}