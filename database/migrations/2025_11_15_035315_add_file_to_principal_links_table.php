<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('principal_links', function (Blueprint $table) {
            $table->json('file')->nullable()->after('url'); // JSON column for multiple files
        });
    }

    public function down(): void
    {
        Schema::table('principal_links', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
};
