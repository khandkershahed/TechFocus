<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('share_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->constrained()->onDelete('cascade');
            $table->string('token')->unique();
            $table->timestamp('expires_at')->nullable();
            $table->json('masked_fields')->nullable(); // Fields to mask
            $table->boolean('allow_copy')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('share_links');
    }
};