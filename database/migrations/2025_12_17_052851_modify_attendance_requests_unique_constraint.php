<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_requests', function (Blueprint $table) {
            // Remove the problematic unique constraint
            $table->dropUnique('unique_pending_request');
            
            // Add a new constraint that only applies to pending requests
            // We'll create a unique index that includes status in the condition
            $table->unique(['meeting_id', 'staff_id'], 'unique_active_request');
            
            // Or simpler: just add a unique constraint for pending status only
            // We'll handle this at application level instead
        });
    }

    public function down(): void
    {
        Schema::table('attendance_requests', function (Blueprint $table) {
            $table->dropUnique('unique_active_request');
            // Re-add the old constraint if needed
            $table->unique(['meeting_id', 'staff_id', 'status'], 'unique_pending_request');
        });
    }
};