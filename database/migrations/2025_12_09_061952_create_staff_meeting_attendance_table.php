<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_meeting_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('staff_meetings')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('admins')->onDelete('cascade');
            $table->string('staff_name');
            $table->string('department')->nullable();
            $table->enum('status', ['present', 'late', 'absent', 'on_leave', 'work_from_field'])->default('absent');
            $table->timestamp('join_time')->nullable();
            $table->timestamp('leave_time')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('requires_approval')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('admins');
            $table->timestamp('approved_at')->nullable();
            $table->string('device_ip')->nullable();
            $table->string('device_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['meeting_id', 'staff_id']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_meeting_attendance');
    }
};