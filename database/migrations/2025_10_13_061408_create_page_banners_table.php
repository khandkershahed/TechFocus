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
public function up(): void
{
    Schema::create('page_banners', function (Blueprint $table) {
        $table->id();
        $table->string('page_name', 191)->nullable();
        $table->string('slug', 150)->nullable();
        $table->string('image', 255)->nullable();
        $table->string('badge', 200)->nullable();
        $table->string('title', 250)->nullable();
        $table->string('button_name', 200)->nullable();
        $table->text('button_link')->nullable();
        $table->text('banner_link')->nullable();
        $table->string('status')->default('active')->comment('inactive,active');
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down(): void
{
    Schema::dropIfExists('page_banners');
}

};
