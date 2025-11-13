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
       
       Schema::create('principal_brand_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('principal_id')->constrained()->onDelete('cascade');
    $table->foreignId('brand_id')->constrained()->onDelete('cascade');
    $table->string('authorization_type')->nullable();
    $table->string('auth_doc_url')->nullable();
    $table->date('valid_from')->nullable();
    $table->date('valid_to')->nullable();
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
        Schema::dropIfExists('principal_brand_links');
    }
};
