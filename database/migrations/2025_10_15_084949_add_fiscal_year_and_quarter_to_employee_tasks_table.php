<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('employee_tasks', 'fiscal_year')) {
                $table->year('fiscal_year')->nullable()->after('title');
            }
            if (!Schema::hasColumn('employee_tasks', 'quarter')) {
                $table->enum('quarter', ['q1','q2','q3','q4'])->nullable()->after('fiscal_year');
            }
        });
    }

    public function down()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->dropColumn(['fiscal_year', 'quarter']);
        });
    }
};
