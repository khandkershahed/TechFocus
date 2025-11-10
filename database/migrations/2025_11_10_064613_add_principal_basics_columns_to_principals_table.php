<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('principals', function (Blueprint $table) {
            $table->string('legal_name')->after('id');
            $table->string('trading_name')->nullable()->after('legal_name');
            $table->enum('entity_type', ['Manufacturer', 'Distributor', 'Supplier', 'Other'])->nullable()->after('trading_name');
            $table->string('website_url')->nullable()->after('entity_type');
            $table->string('country_iso', 2)->nullable()->comment('ISO 3166-1 alpha-2 country code')->after('website_url');
            $table->string('hq_city')->nullable()->after('country_iso');
            $table->enum('relationship_status', ['Prospect', 'Active', 'Dormant', 'Closed'])->default('Prospect')->after('hq_city');
            $table->longText('notes')->nullable()->comment('Rich text, internal notes')->after('relationship_status');
            $table->timestamp('archived_at')->nullable()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('principals', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name',
                'trading_name',
                'entity_type',
                'website_url',
                'country_iso',
                'hq_city',
                'relationship_status',
                'notes',
                'archived_at',
            ]);
        });
    }
};
