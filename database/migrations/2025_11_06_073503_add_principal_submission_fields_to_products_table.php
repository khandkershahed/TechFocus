<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add principal_id for principal submissions
            if (!Schema::hasColumn('products', 'principal_id')) {
                $table->foreignId('principal_id')->nullable()->constrained('principals')->onDelete('cascade');
            }
            
            // Add submission_status for principal approval workflow
            if (!Schema::hasColumn('products', 'submission_status')) {
                $table->enum('submission_status', ['pending', 'approved', 'rejected'])->default('approved');
            }
            
            // Add rejection_reason for when products are rejected
            if (!Schema::hasColumn('products', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            
            // Add approved_at timestamp
            if (!Schema::hasColumn('products', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'principal_id',
                'submission_status', 
                'rejection_reason',
                'approved_at'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    if ($column === 'principal_id') {
                        $table->dropForeign(['principal_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};