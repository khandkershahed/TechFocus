<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, create temporary columns with the new data types
        Schema::table('rfq_products', function (Blueprint $table) {
            // Add temporary decimal columns
            $table->decimal('temp_unit_price', 15, 2)->default(0)->after('unit_price');
            $table->decimal('temp_discount', 8, 2)->default(0)->after('discount'); // Increased precision
            $table->decimal('temp_discount_price', 15, 2)->default(0)->after('discount_price');
            $table->decimal('temp_total_price', 15, 2)->default(0)->after('total_price');
            $table->decimal('temp_sub_total', 15, 2)->default(0)->after('sub_total');
            $table->decimal('temp_tax', 8, 2)->default(0)->after('tax'); // Increased precision
            $table->decimal('temp_tax_price', 15, 2)->default(0)->after('tax_price');
            $table->decimal('temp_vat', 8, 2)->default(0)->after('vat'); // Increased precision
            $table->decimal('temp_vat_price', 15, 2)->default(0)->after('vat_price');
            $table->decimal('temp_grand_total', 15, 2)->default(0)->after('grand_total');
        });

        // Copy and convert data safely
        DB::statement('
            UPDATE rfq_products SET 
                temp_unit_price = CAST(COALESCE(unit_price, 0) AS DECIMAL(15,2)),
                temp_discount = CAST(COALESCE(discount, 0) AS DECIMAL(8,2)),
                temp_discount_price = CAST(COALESCE(discount_price, 0) AS DECIMAL(15,2)),
                temp_total_price = CAST(COALESCE(total_price, 0) AS DECIMAL(15,2)),
                temp_sub_total = CAST(COALESCE(sub_total, 0) AS DECIMAL(15,2)),
                temp_tax = CAST(COALESCE(tax, 0) AS DECIMAL(8,2)),
                temp_tax_price = CAST(COALESCE(tax_price, 0) AS DECIMAL(15,2)),
                temp_vat = CAST(COALESCE(vat, 0) AS DECIMAL(8,2)),
                temp_vat_price = CAST(COALESCE(vat_price, 0) AS DECIMAL(15,2)),
                temp_grand_total = CAST(COALESCE(grand_total, 0) AS DECIMAL(15,2))
        ');

        // Handle any values that might be too large for discount/tax/vat
        DB::statement('
            UPDATE rfq_products SET 
                temp_discount = CASE 
                    WHEN discount > 100 THEN 100 
                    WHEN discount < 0 THEN 0 
                    ELSE temp_discount 
                END,
                temp_tax = CASE 
                    WHEN tax > 100 THEN 100 
                    WHEN tax < 0 THEN 0 
                    ELSE temp_tax 
                END,
                temp_vat = CASE 
                    WHEN vat > 100 THEN 100 
                    WHEN vat < 0 THEN 0 
                    ELSE temp_vat 
                END
        ');

        // Drop the old columns
        Schema::table('rfq_products', function (Blueprint $table) {
            $table->dropColumn([
                'unit_price',
                'discount', 
                'discount_price',
                'total_price',
                'sub_total',
                'tax',
                'tax_price',
                'vat',
                'vat_price',
                'grand_total'
            ]);
        });

        // Rename the temporary columns to original names
        Schema::table('rfq_products', function (Blueprint $table) {
            $table->renameColumn('temp_unit_price', 'unit_price');
            $table->renameColumn('temp_discount', 'discount');
            $table->renameColumn('temp_discount_price', 'discount_price');
            $table->renameColumn('temp_total_price', 'total_price');
            $table->renameColumn('temp_sub_total', 'sub_total');
            $table->renameColumn('temp_tax', 'tax');
            $table->renameColumn('temp_tax_price', 'tax_price');
            $table->renameColumn('temp_vat', 'vat');
            $table->renameColumn('temp_vat_price', 'vat_price');
            $table->renameColumn('temp_grand_total', 'grand_total');
        });

        // Add the foreign key and indexes
        Schema::table('rfq_products', function (Blueprint $table) {
            // Add foreign key for product_id
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            
            // Add indexes
            $table->index(['rfq_id', 'product_id']);
            $table->index('sku_no');
        });
    }

    public function down()
    {
        // Remove indexes and foreign key first
        Schema::table('rfq_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropIndex(['rfq_id', 'product_id']);
            $table->dropIndex(['sku_no']);
        });

        // Revert to original double columns if needed
        Schema::table('rfq_products', function (Blueprint $table) {
            $table->double('unit_price')->nullable()->change();
            $table->double('discount')->nullable()->change();
            $table->double('discount_price')->nullable()->change();
            $table->double('total_price')->nullable()->change();
            $table->double('sub_total')->nullable()->change();
            $table->double('tax')->nullable()->change();
            $table->double('tax_price')->nullable()->change();
            $table->double('vat')->nullable()->change();
            $table->double('vat_price')->nullable()->change();
            $table->double('grand_total')->nullable()->change();
        });
    }
};