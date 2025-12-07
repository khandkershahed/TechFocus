<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movement_records', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('duration')->nullable();
            $table->string('area')->nullable();
            $table->string('transport')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('meeting_type')->nullable();
            $table->string('company')->nullable(); 
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->string('value_status')->nullable();
            $table->text('purpose')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_records');
    }
};