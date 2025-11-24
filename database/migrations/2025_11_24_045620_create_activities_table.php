<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->constrained()->onDelete('cascade');
            $table->string('type'); // note, task, link_shared, file_uploaded, status_changed, edited, created
            $table->string('subtype')->nullable(); // created, updated, deleted
            $table->text('description');
            $table->text('rich_content')->nullable(); // For rich text content
            $table->morphs('created_by'); // Can be principal or admin
            $table->boolean('pinned')->default(false);
            $table->json('mentioned_users')->nullable(); // Store mentioned user IDs
            $table->json('metadata')->nullable(); // Additional data like file info, status changes, etc.
            $table->string('related_type')->nullable(); // brand, product, contract, user
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['principal_id', 'created_at']);
            $table->index(['related_type', 'related_id']);
            $table->index('pinned');
            $table->index('type');
        });

        // Create mentions pivot table
        Schema::create('activity_mentions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['activity_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_mentions');
        Schema::dropIfExists('activities');
    }
};