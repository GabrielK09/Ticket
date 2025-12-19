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
        Schema::create('customer_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_config_id')->index();

            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            
            $table->unsignedBigInteger('owner_id');

            // true = Sim
            // false = Não

            // J = Júridica
            // F = Física

            $table->string('default_type')->default('J');
            $table->boolean('trande_name_null')->default(false);
            $table->boolean('phone_null')->default(false);
            $table->boolean('address_null')->default(false);
            $table->boolean('number_address_null')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_configs');
    }
};