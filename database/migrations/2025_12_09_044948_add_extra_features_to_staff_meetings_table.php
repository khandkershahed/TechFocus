<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('staff_meetings', function (Blueprint $table) {
            // For meeting reminders
            $table->timestamp('email_reminder_sent_at')->nullable();
            $table->timestamp('whatsapp_reminder_sent_at')->nullable();
            $table->text('reminder_message')->nullable();
            
            // For attendance link
            $table->string('attendance_link')->nullable();
            $table->string('attendance_qr_code')->nullable();
            
            // For meeting minutes
            $table->text('meeting_minutes')->nullable();
            $table->json('minutes_attachments')->nullable();
            $table->foreignId('minutes_uploaded_by')->nullable()->constrained('admins');
            $table->timestamp('minutes_uploaded_at')->nullable();
            
            // For approvals
            $table->enum('minutes_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('admins');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            
            // For automated features
            $table->string('meeting_link')->nullable(); // Zoom/Google Meet link
            $table->boolean('auto_generate_link')->default(false);
            $table->boolean('send_auto_reminders')->default(true);
        });
    }

    public function down()
    {
        Schema::table('staff_meetings', function (Blueprint $table) {
            $table->dropColumn([
                'email_reminder_sent_at',
                'whatsapp_reminder_sent_at',
                'reminder_message',
                'attendance_link',
                'attendance_qr_code',
                'meeting_minutes',
                'minutes_attachments',
                'minutes_uploaded_by',
                'minutes_uploaded_at',
                'minutes_status',
                'approved_by',
                'approved_at',
                'approval_notes',
                'meeting_link',
                'auto_generate_link',
                'send_auto_reminders'
            ]);
            $table->dropForeign(['minutes_uploaded_by']);
            $table->dropForeign(['approved_by']);
        });
    }
};