<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movement_records', function (Blueprint $table) {
            // Add admin_id column
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            
            // You can also add indexes if needed
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movement_records', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};