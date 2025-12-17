<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table exists
        if (Schema::hasTable('attendance_requests')) {
            // Add missing columns if they don't exist
            Schema::table('attendance_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('attendance_requests', 'approved_by')) {
                    $table->foreignId('approved_by')->nullable()->constrained('admins')->after('status');
                }
                
                if (!Schema::hasColumn('attendance_requests', 'approved_at')) {
                    $table->timestamp('approved_at')->nullable()->after('approved_by');
                }
                
                if (!Schema::hasColumn('attendance_requests', 'admin_notes')) {
                    $table->text('admin_notes')->nullable()->after('approved_at');
                }
                
                if (!Schema::hasColumn('attendance_requests', 'requested_at')) {
                    $table->timestamp('requested_at')->useCurrent()->after('staff_id');
                }
                
                // Add foreign keys if they don't exist
                if (!Schema::hasColumn('attendance_requests', 'meeting_id')) {
                    $table->foreignId('meeting_id')->constrained('staff_meetings')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('attendance_requests', 'staff_id')) {
                    $table->foreignId('staff_id')->constrained('admins')->onDelete('cascade');
                }
                
                // Add indexes
                $table->index(['meeting_id', 'staff_id']);
                $table->index(['status', 'created_at']);
                
                // Add unique constraint for pending requests
                if (Schema::hasColumn('attendance_requests', 'meeting_id') && 
                    Schema::hasColumn('attendance_requests', 'staff_id') &&
                    Schema::hasColumn('attendance_requests', 'status')) {
                    
                    $table->unique(['meeting_id', 'staff_id', 'status'], 'unique_pending_request');
                }
            });
        } else {
            // Create table if doesn't exist
            Schema::create('attendance_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('meeting_id')->constrained('staff_meetings')->onDelete('cascade');
                $table->foreignId('staff_id')->constrained('admins')->onDelete('cascade');
                $table->timestamp('requested_at')->useCurrent();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->foreignId('approved_by')->nullable()->constrained('admins');
                $table->timestamp('approved_at')->nullable();
                $table->text('admin_notes')->nullable();
                $table->timestamps();
                
                $table->unique(['meeting_id', 'staff_id', 'status'], 'unique_pending_request');
                $table->index(['status', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        // Don't drop table, just remove added columns
        Schema::table('attendance_requests', function (Blueprint $table) {
            $columns = ['approved_by', 'approved_at', 'admin_notes', 'requested_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('attendance_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Drop unique constraint if exists
            $table->dropUnique('unique_pending_request');
            
            // Drop indexes
            $table->dropIndex(['meeting_id', 'staff_id']);
            $table->dropIndex(['status', 'created_at']);
        });
    }
};