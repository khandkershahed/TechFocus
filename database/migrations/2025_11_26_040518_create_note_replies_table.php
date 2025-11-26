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
        Schema::create('note_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // App\Models\Principal, App\Models\Admin, etc.
            $table->text('reply');
            $table->json('metadata')->nullable(); // For future extensions like attachments in replies
            $table->timestamps();

            // Index for polymorphic relationship and performance
            $table->index(['user_id', 'user_type']);
            $table->index('activity_id');
            $table->index('created_at');
        });

        // Add replies_count to activities table for better performance
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedInteger('replies_count')->default(0)->after('metadata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_replies');
        
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('replies_count');
        });
    }
};