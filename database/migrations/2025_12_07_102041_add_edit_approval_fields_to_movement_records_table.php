<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('movement_records', function (Blueprint $table) {
        $table->string('edit_status')->nullable()->comment('pending, approved, rejected');
        $table->unsignedBigInteger('edit_requested_by')->nullable();
        $table->timestamp('edit_requested_at')->nullable();
        $table->unsignedBigInteger('edit_approved_by')->nullable();
        $table->timestamp('edit_approved_at')->nullable();
    });
}

public function down()
{
    Schema::table('movement_records', function (Blueprint $table) {
        $table->dropColumn([
            'edit_status',
            'edit_requested_by',
            'edit_requested_at',
            'edit_approved_by',
            'edit_approved_at',
        ]);
    });
}

};