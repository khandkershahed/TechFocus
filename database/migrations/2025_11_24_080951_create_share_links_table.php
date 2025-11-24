<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_share_links_table.php

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
            $table->json('allowed_fields'); // Fields that are visible
            $table->json('masked_fields')->nullable(); // Fields to be masked
            $table->timestamp('expires_at');
            $table->integer('max_views')->nullable(); // Maximum number of views
            $table->integer('view_count')->default(0);
            $table->boolean('allow_download')->default(false);
            $table->boolean('disable_copy')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('token');
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('share_links');
    }
};