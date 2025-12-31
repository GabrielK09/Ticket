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
        Schema::create('technicals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technical_id')->index();
            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->unsignedBigInteger('owner_id');
            $table->string('company_name', 120);
            $table->string('trade_name', 120)->nullable();
            $table->string('cnpj_cpf', 14);
            $table->string('phone', 24)->nullable();
            $table->string('cep', 60);
            $table->string('address', 60)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('gender', 1);
            $table->boolean('availability')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicals');
    }
};
