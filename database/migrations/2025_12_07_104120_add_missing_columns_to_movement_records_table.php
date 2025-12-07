<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movement_records', function (Blueprint $table) {
            // Check if columns exist before adding them
            
            if (!Schema::hasColumn('movement_records', 'country_id')) {
                $table->foreignId('country_id')->nullable()->constrained('countries');
            }
            
            if (!Schema::hasColumn('movement_records', 'date')) {
                $table->date('date');
            }
            
            if (!Schema::hasColumn('movement_records', 'status')) {
                $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            }
            
            if (!Schema::hasColumn('movement_records', 'start_time')) {
                $table->time('start_time')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'end_time')) {
                $table->time('end_time')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'duration')) {
                $table->time('duration')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'meeting_type')) {
                $table->enum('meeting_type', ['follow-up', 'meeting', 'presentation', 'negotiation', 'site-visit'])->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'company')) {
                $table->string('company')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'contact_person')) {
                $table->string('contact_person')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'contact_number')) {
                $table->string('contact_number')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'purpose')) {
                $table->text('purpose');
            }
            
            if (!Schema::hasColumn('movement_records', 'area')) {
                $table->string('area')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'transport')) {
                $table->enum('transport', ['car', 'train', 'bus', 'flight', 'taxi', 'walking'])->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'cost')) {
                $table->decimal('cost', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'value')) {
                $table->decimal('value', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'value_status')) {
                $table->enum('value_status', ['pending', 'negotiating', 'closed', 'lost'])->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'comments')) {
                $table->text('comments')->nullable();
            }
            
            // Add edit approval fields if not already added
            if (!Schema::hasColumn('movement_records', 'edit_status')) {
                $table->string('edit_status')->nullable()->comment('pending, approved, rejected');
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_requested_by')) {
                $table->unsignedBigInteger('edit_requested_by')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_requested_at')) {
                $table->timestamp('edit_requested_at')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_approved_by')) {
                $table->unsignedBigInteger('edit_approved_by')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_approved_at')) {
                $table->timestamp('edit_approved_at')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_rejection_reason')) {
                $table->text('edit_rejection_reason')->nullable();
            }
            
            if (!Schema::hasColumn('movement_records', 'edit_request_reason')) {
                $table->text('edit_request_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('movement_records', function (Blueprint $table) {
            // Remove only the columns we added in this migration
            $columnsToDrop = [
                'country_id',
                'date',
                'status',
                'start_time',
                'end_time',
                'duration',
                'meeting_type',
                'company',
                'contact_person',
                'contact_number',
                'purpose',
                'area',
                'transport',
                'cost',
                'value',
                'value_status',
                'comments',
                'edit_status',
                'edit_requested_by',
                'edit_requested_at',
                'edit_approved_by',
                'edit_approved_at',
                'edit_rejection_reason',
                'edit_request_reason'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('movement_records', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};