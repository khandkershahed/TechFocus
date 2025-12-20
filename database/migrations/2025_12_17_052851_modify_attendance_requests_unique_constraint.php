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

        // Drop old index safely if exists
        $indexes = DB::select("
            SHOW INDEX FROM attendance_requests 
            WHERE Key_name = 'unique_pending_request'
        ");

        if (!empty($indexes)) {
            $table->dropUnique('unique_pending_request');
        }

        // ❌ DO NOT add new unique constraint
        // Pending uniqueness must be handled in code
    });
}

public function down(): void
{
    Schema::table('attendance_requests', function (Blueprint $table) {
        // Nothing to restore
    });
}

};
