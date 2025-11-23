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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_register_id')->index();
            
            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->foreign('customer_id')->references('customer_id')->on('customers')->cascadeOnDelete();
            $table->foreign('pay_ment_form_id')->references('pay_ment_form_id')->on('pay_ment_forms')->cascadeOnDelete();
            
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pay_ment_form_id');

            $table->string('pay_ment_form', 60);
            $table->string('customer', 120);

            $table->float('input_value', 16.2);
            $table->float('output_value', 16.2);
            $table->float('balance', 16.2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
