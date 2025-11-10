<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('principal_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->constrained('principals')->cascadeOnDelete();

            $table->string('contact_name');
            $table->string('job_title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_e164')->nullable()->comment('Phone in E.164 format');
            $table->string('whatsapp_e164')->nullable()->comment('WhatsApp in E.164 format');
            $table->string('wechat_id')->nullable();
            $table->enum('preferred_channel', ['Email', 'WhatsApp', 'WeChat', 'Phone'])->nullable();
            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('principal_contacts');
    }
};
