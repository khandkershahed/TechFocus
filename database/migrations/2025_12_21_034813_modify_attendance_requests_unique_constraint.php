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

            // Drop foreign key(s) if they exist
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'attendance_requests'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            foreach ($foreignKeys as $fk) {
                try {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                } catch (\Throwable $e) {
                    // ignore
                }
            }

            // Drop old unique index if exists
            $indexes = DB::select("
                SHOW INDEX 
                FROM attendance_requests 
                WHERE Key_name = 'unique_pending_request'
            ");

            if (!empty($indexes)) {
                $table->dropUnique('unique_pending_request');
            }
        });
    }

    public function down(): void
    {
        // intentionally empty
    }
};
