<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->string('section_solutions_name')->nullable();
            $table->string('section_solutions_title')->nullable();
            $table->string('section_solutions_badge')->nullable();
            $table->string('section_solutions_button')->nullable();
            $table->string('section_solutions_link')->nullable();
            $table->json('section_solutions_items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn([
                'section_solutions_name',
                'section_solutions_title',
                'section_solutions_badge',
                'section_solutions_button',
                'section_solutions_link',
                'section_solutions_items'
            ]);
        });
    }
};