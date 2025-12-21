<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add replacement index for FK
        DB::statement('
            CREATE INDEX attendance_requests_meeting_id_idx
            ON attendance_requests (meeting_id)
        ');

        // 2. Drop the unique constraint
        DB::statement('
            ALTER TABLE attendance_requests
            DROP INDEX unique_pending_request
        ');
    }

    public function down(): void
    {
        // No rollback
    }
};
