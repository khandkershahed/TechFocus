<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('principal_Dashboardcontacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // added brand foreign key
            $table->string('type'); // e.g., email, phone, etc.
            $table->string('label')->nullable(); // optional label or description
            $table->string('file_url')->nullable(); // optional file attachment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('principal_Dashboardcontacts');
    }
};
