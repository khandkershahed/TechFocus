<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->string('scope_type'); // brand, category, solution, country
            $table->unsignedBigInteger('scope_id'); // polymorphic relation
            $table->timestamps();

            $table->unique(['role_id', 'scope_type', 'scope_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_scopes');
    }
};