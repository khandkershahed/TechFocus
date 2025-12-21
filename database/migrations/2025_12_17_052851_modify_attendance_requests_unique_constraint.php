<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_requests', function (Blueprint $table) {

            // 1. Drop the foreign key FIRST
            if (Schema::hasColumn('attendance_requests', 'user_id')) {
                $table->dropForeign(['user_id']); // <-- adjust column if needed
            }

            // 2. Drop the unique index
            $indexes = DB::select("
                SHOW INDEX FROM attendance_requests 
                WHERE Key_name = 'unique_pending_request'
            ");

            if (!empty($indexes)) {
                $table->dropUnique('unique_pending_request');
            }

            // 3. Re-add a normal (non-unique) index for FK support
            $table->index('user_id');
        });

        // 4. Recreate the foreign key
        Schema::table('attendance_requests', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('attendance_requests', function (Blueprint $table) {
            // Nothing to restore
        });
    }
};
