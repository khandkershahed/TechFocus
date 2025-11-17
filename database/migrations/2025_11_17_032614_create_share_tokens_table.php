<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('share_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->unique();
            $table->foreignId('principal_link_id')->constrained()->onDelete('cascade');
            $table->foreignId('principal_id')->constrained('principals')->onDelete('cascade');
            $table->timestamp('expires_at');
            $table->json('settings')->nullable(); // Store share settings
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('share_tokens');
    }
};