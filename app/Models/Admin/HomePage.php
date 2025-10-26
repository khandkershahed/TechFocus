<?php
// app/Models/Admin/HomePage.php

namespace App\Models\Admin;

use App\Models\Country;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'section_one_name',
        'section_one_badge',
        'section_one_title',
        'section_one_description',
        'section_one_button',
        'section_one_link',
        'section_one_image',
        'section_two_name',
        'section_two_products',
        'section_three_name',
        'section_three_badge',
        'section_three_title',
        'section_three_button',
        'section_three_link',

        'section_solutions_name',
        'section_solutions_title',
        'section_solutions_badge',
        'section_solutions_button',
        'section_solutions_link',
        'section_solutions_items',

        'section_three_first_column_logo',
        'section_three_first_column_title',
        'section_three_first_column_link',
        'section_three_second_column_logo',
        'section_three_second_column_title',
        'section_three_second_column_link',
        'section_three_third_column_logo',
        'section_three_third_column_title',
        'section_three_third_column_link',
        'section_three_fourth_column_logo',
        'section_three_fourth_column_title',
        'section_three_fourth_column_link',
        'section_four_name',
        'section_four_contents',
        'section_five_title',
        'section_five_link_one_title',
        'section_five_link_one_icon',
        'section_five_link_one_link',
        'section_five_link_two_title',
        'section_five_link_two_icon',
        'section_five_link_two_link',
        'section_five_link_three_title',
        'section_five_link_three_icon',
        'section_five_link_three_link',
        'section_five_button_title',
        'section_five_button_sub_title',
        'section_five_button_link',
        'section_six_name',
        'section_six_first_column_image',
        'section_six_first_column_title',
        'section_six_first_column_description',
        'section_six_first_column_button_name',
        'section_six_first_column_button_link',
        'section_six_second_column_image',
        'section_six_second_column_title',
        'section_six_second_column_description',
        'section_six_second_column_button_name',
        'section_six_second_column_button_link',
        'section_six_third_column_image',
        'section_six_third_column_title',
        'section_six_third_column_description',
        'section_six_third_column_button_name',
        'section_six_third_column_button_link',
        'section_seven_name',
        'section_seven_badge',
        'section_seven_title',
        'section_seven_description',
        'section_seven_button',
        'section_seven_link',
        'section_seven_first_grid_icon',
        'section_seven_first_grid_title',
        'section_seven_first_grid_button_name',
        'section_seven_first_grid_button_link',
        'section_seven_second_grid_icon',
        'section_seven_second_grid_title',
        'section_seven_second_grid_button_name',
        'section_seven_second_grid_button_link',
        'section_seven_third_grid_icon',
        'section_seven_third_grid_title',
        'section_seven_third_grid_button_name',
        'section_seven_third_grid_button_link',
        'section_seven_fourth_grid_icon',
        'section_seven_fourth_grid_title',
        'section_seven_fourth_grid_button_name',
        'section_seven_fourth_grid_button_link',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the country associated with the home page.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Cast JSON fields to array
     */
    protected $casts = [
        'section_two_products' => 'array',
        'section_four_contents' => 'array',
        'section_solutions_items' => 'array',
    ];

    /**
     * Get the user who created the home page.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the home page.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessor for section one image URL
     */
    public function getSectionOneImageUrlAttribute()
    {
        return $this->section_one_image ? asset('storage/home-page/image/' . $this->section_one_image) : null;
    }

    /**
     * Accessor for section three logos URLs
     */
    public function getSectionThreeFirstColumnLogoUrlAttribute()
    {
        return $this->section_three_first_column_logo ? asset('storage/home-page/logo/' . $this->section_three_first_column_logo) : null;
    }

    public function getSectionThreeSecondColumnLogoUrlAttribute()
    {
        return $this->section_three_second_column_logo ? asset('storage/home-page/logo/' . $this->section_three_second_column_logo) : null;
    }

    public function getSectionThreeThirdColumnLogoUrlAttribute()
    {
        return $this->section_three_third_column_logo ? asset('storage/home-page/logo/' . $this->section_three_third_column_logo) : null;
    }

    public function getSectionThreeFourthColumnLogoUrlAttribute()
    {
        return $this->section_three_fourth_column_logo ? asset('storage/home-page/logo/' . $this->section_three_fourth_column_logo) : null;
    }

    /**
     * Accessor for section six images URLs
     */
    public function getSectionSixFirstColumnImageUrlAttribute()
    {
        return $this->section_six_first_column_image ? asset('storage/home-page/image/' . $this->section_six_first_column_image) : null;
    }

    public function getSectionSixSecondColumnImageUrlAttribute()
    {
        return $this->section_six_second_column_image ? asset('storage/home-page/image/' . $this->section_six_second_column_image) : null;
    }

    public function getSectionSixThirdColumnImageUrlAttribute()
    {
        return $this->section_six_third_column_image ? asset('storage/home-page/image/' . $this->section_six_third_column_image) : null;
    }

    /**
     * Accessor for section seven icons URLs
     */
    public function getSectionSevenFirstGridIconUrlAttribute()
    {
        return $this->section_seven_first_grid_icon ? asset('storage/home-page/icon/' . $this->section_seven_first_grid_icon) : null;
    }

    public function getSectionSevenSecondGridIconUrlAttribute()
    {
        return $this->section_seven_second_grid_icon ? asset('storage/home-page/icon/' . $this->section_seven_second_grid_icon) : null;
    }

    public function getSectionSevenThirdGridIconUrlAttribute()
    {
        return $this->section_seven_third_grid_icon ? asset('storage/home-page/icon/' . $this->section_seven_third_grid_icon) : null;
    }

    public function getSectionSevenFourthGridIconUrlAttribute()
    {
        return $this->section_seven_fourth_grid_icon ? asset('storage/home-page/icon/' . $this->section_seven_fourth_grid_icon) : null;
    }

    /**
     * Check if section one has content
     */
    public function getHasSectionOneAttribute()
    {
        return !empty($this->section_one_title) || !empty($this->section_one_description);
    }

    /**
     * Check if section two has content
     */
    public function getHasSectionTwoAttribute()
    {
        return !empty($this->section_two_name) && !empty($this->section_two_products);
    }

    /**
     * Check if section three has content
     */
    public function getHasSectionThreeAttribute()
    {
        return !empty($this->section_three_title);
    }

    /**
     * Check if section four has content
     */
    public function getHasSectionFourAttribute()
    {
        return !empty($this->section_four_name) && !empty($this->section_four_contents);
    }

    /**
     * Check if section five has content
     */
    public function getHasSectionFiveAttribute()
    {
        return !empty($this->section_five_title);
    }

    /**
     * Check if section six has content
     */
    public function getHasSectionSixAttribute()
    {
        return !empty($this->section_six_name);
    }

    /**
     * Check if section seven has content
     */
    public function getHasSectionSevenAttribute()
    {
        return !empty($this->section_seven_title);
    }
}