<?php

namespace App\Models;

use Hash;
use App\Models\Favorite;
use App\Models\Admin\NewsTrend;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'user_type',
        'phone',
        'company_name',
        'photo',
        'code',
        'about',
        'support_tier',
        'support_tier_description',
        'address',
        'city',
        'postal',
        'last_seen',
        'status',
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
      
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'company_established_date' => 'date',
    ];

    /**
     * Auto hash password when create/update.
     *
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::needsRehash($value) ? \Hash::make($value) : $value;
    }

        public function favourites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }
      public function newsTrends()
    {
        return $this->hasMany(NewsTrend::class, 'added_by');
    }
}
