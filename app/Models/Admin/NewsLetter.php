<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class NewsLetter extends Model
{
    use HasFactory, Userstamps;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'ip_address',
        'location',
        'created_by',
        'updated_by',
    ];
}
