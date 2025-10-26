<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('employee_tasks', 'month')) {
                $table->string('month')->nullable()->after('quarter');
            }
        });
    }

    public function down()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->dropColumn('month');
        });
    }
};
