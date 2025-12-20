<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_id')->constrained('privacy_policies')->onDelete('cascade');
            $table->string('section_title');
            $table->string('section_number')->nullable();
            $table->text('section_content');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_sections');
    }
};