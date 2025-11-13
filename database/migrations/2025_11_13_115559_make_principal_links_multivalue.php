<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('principal_links', function (Blueprint $table) {
            $table->json('label')->nullable()->change();
            $table->json('url')->nullable()->change();
            // Don't add type again if it already exists
        });
    }

    public function down()
    {
        Schema::table('principal_links', function (Blueprint $table) {
            $table->string('label')->change();
            $table->string('url')->change();
            // Don't drop type if it already exists
        });
    }
};
