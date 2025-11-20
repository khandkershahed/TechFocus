<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Drop old foreign keys first
            $table->dropForeign(['expense_category']);
            $table->dropForeign(['expense_type']);

            // Rename columns
            $table->renameColumn('expense_category', 'expense_category_id');
            $table->renameColumn('expense_type', 'expense_type_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Recreate foreign keys with new column names
            $table->foreign('expense_category_id')
                ->references('id')->on('expense_categories')
                ->onUpdate('cascade');

            $table->foreign('expense_type_id')
                ->references('id')->on('expense_types')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Drop new foreign keys
            $table->dropForeign(['expense_category_id']);
            $table->dropForeign(['expense_type_id']);

            // Rename columns back
            $table->renameColumn('expense_category_id', 'expense_category');
            $table->renameColumn('expense_type_id', 'expense_type');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Recreate original foreign keys
            $table->foreign('expense_category')
                ->references('id')->on('expense_categories')
                ->onUpdate('cascade');

            $table->foreign('expense_type')
                ->references('id')->on('expense_types')
                ->onUpdate('cascade');
        });
    }
};
