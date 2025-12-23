<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create cookie_policies table
        Schema::create('cookie_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Cookie Policy');
            $table->longText('content');
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->index(['is_active']);
        });

        // Create cookie_consents table
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('consent_token')->unique()->nullable();
            $table->json('preferences')->nullable(); // Store cookie categories
            $table->boolean('accepted')->default(false);
            $table->timestamp('consented_at')->useCurrent();
            $table->timestamps();
            
            $table->index(['ip_address', 'accepted']);
            $table->index(['consent_token']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
        Schema::dropIfExists('cookie_policies');
    }
};