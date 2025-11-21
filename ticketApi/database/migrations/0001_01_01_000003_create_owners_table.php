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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 120);
            $table->string('trade_name', 120);
            $table->string('cnpj_cpf', 14);
            $table->string('phone', 24);
            $table->string('cep', 60);
            $table->string('address', 60);
            $table->string('number', 10);
            $table->string('cnae', 14);
            $table->string('active', 120);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
