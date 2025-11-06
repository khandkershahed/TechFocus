<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add principal_id if it doesn't exist
            if (!Schema::hasColumn('products', 'principal_id')) {
                $table->foreignId('principal_id')->nullable()->constrained('principals')->onDelete('cascade');
            }
            
            // Modify the existing status column to include approval status
            // We'll rename the existing status and add a new approval_status column
            if (Schema::hasColumn('products', 'status')) {
                // Rename the existing status to product_status (if not already done)
                if (!Schema::hasColumn('products', 'product_visibility_status')) {
                    $table->renameColumn('status', 'product_visibility_status');
                }
            }
            
            // Add approval_status column for principal submissions
            if (!Schema::hasColumn('products', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('approved')->after('principal_id');
            }
            
            // Add rejection_reason if missing
            if (!Schema::hasColumn('products', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approval_status');
            }
            
            // Add approved_at if missing
            if (!Schema::hasColumn('products', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('rejection_reason');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the new columns we added
            if (Schema::hasColumn('products', 'principal_id')) {
                $table->dropForeign(['principal_id']);
                $table->dropColumn('principal_id');
            }
            
            if (Schema::hasColumn('products', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
            
            if (Schema::hasColumn('products', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
            
            if (Schema::hasColumn('products', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            
            // Rename back if we changed it
            if (Schema::hasColumn('products', 'product_visibility_status') && !Schema::hasColumn('products', 'status')) {
                $table->renameColumn('product_visibility_status', 'status');
            }
        });
    }
};