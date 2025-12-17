<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('staff_meeting_attendance', function (Blueprint $table) {
        if (!Schema::hasColumn('staff_meeting_attendance', 'requested_at')) {
            $table->timestamp('requested_at')->nullable()->after('staff_id');
        }
        if (!Schema::hasColumn('staff_meeting_attendance', 'actual_join_time')) {
            $table->timestamp('actual_join_time')->nullable()->after('join_time');
        }
        if (!Schema::hasColumn('staff_meeting_attendance', 'meeting_start_time')) {
            $table->timestamp('meeting_start_time')->nullable()->after('actual_join_time');
        }
    });
}

public function down()
{
    Schema::table('staff_meeting_attendance', function (Blueprint $table) {
        $table->dropColumn(['requested_at', 'actual_join_time', 'meeting_start_time']);
    });
}
};
