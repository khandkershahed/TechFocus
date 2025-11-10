<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('principal_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->constrained('principals')->cascadeOnDelete();

            $table->enum('type', ['HQ', 'Billing', 'Shipping', 'Other'])->default('Other');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal')->nullable();
            $table->string('country_iso', 2)->nullable()->comment('ISO 3166-1 alpha-2 country code');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('principal_addresses');
    }
};
