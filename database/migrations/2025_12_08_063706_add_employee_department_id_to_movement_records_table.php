<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movement_records', function (Blueprint $table) {
            $table->foreignId('employee_department_id')
                ->nullable()
                ->after('id') // optional position
                ->constrained('employee_departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('movement_records', function (Blueprint $table) {
            $table->dropForeign(['employee_department_id']);
            $table->dropColumn('employee_department_id');
        });
    }
};

