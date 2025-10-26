<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::table('tasks', function (Blueprint $table) {
    if (!Schema::hasColumn('tasks', 'start_date')) {
        $table->date('start_date')->nullable()->after('employee_task_id');
    }

    if (!Schema::hasColumn('tasks', 'end_date')) {
        $table->date('end_date')->nullable()->after('start_date');
    }

    if (!Schema::hasColumn('tasks', 'start_time')) {
        $table->time('start_time')->nullable()->after('end_date');
    }

    if (!Schema::hasColumn('tasks', 'end_time')) {
        $table->time('end_time')->nullable()->after('start_time');
    }

    if (!Schema::hasColumn('tasks', 'buffer_time')) {
        $table->time('buffer_time')->nullable()->after('end_time');
    }

    if (!Schema::hasColumn('tasks', 'location')) {
        $table->string('location')->nullable()->after('buffer_time');
    }

    if (!Schema::hasColumn('tasks', 'task_description')) {
        $table->text('task_description')->nullable()->after('location');
    }

    if (!Schema::hasColumn('tasks', 'task_target')) {
        $table->string('task_target')->nullable()->after('task_description');
    }

    if (!Schema::hasColumn('tasks', 'task_rating')) {
        $table->string('task_rating')->nullable()->after('task_target');
    }

    if (!Schema::hasColumn('tasks', 'task_weight')) {
        $table->integer('task_weight')->nullable()->after('task_rating');
    }
});

    }

    public function down()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->dropColumn(['fiscal_year', 'quarter', 'month']);
        });
    }
};
