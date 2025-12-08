<?php
// database/migrations/xxxx_create_staff_meetings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffMeetingsTable extends Migration
{
    public function up()
    {
        Schema::create('staff_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('lead_by')->nullable()->constrained('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->json('participants')->nullable();
            $table->enum('type', ['office', 'out_of_office'])->default('office')->nullable();
            $table->enum('category', [
                'management',
                'departmental', 
                'training',
                'hr_policy_compliance',
                'client_review',
                'project_review',
                'weekly_coordination',
                'emergency_meeting'
            ])->nullable();
            $table->string('department')->nullable();
            $table->enum('platform', [
                'office',
                'online',
                'client_office',
                'training_center'
            ])->default('office')->nullable();
            $table->string('online_platform')->nullable(); // Zoom/Meet/Teams
            $table->foreignId('organizer_id')->nullable()->constrained('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('agenda')->nullable();
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['scheduled', 'rescheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_meetings');
    }
}