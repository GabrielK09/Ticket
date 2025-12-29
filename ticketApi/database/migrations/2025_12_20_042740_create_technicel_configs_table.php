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
        Schema::create('technicel_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technicel_config_id')->index();

            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->unsignedBigInteger('owner_id');

            $table->string('default_type', 1)->default('J');
            $table->boolean('trade_name_null')->default(false);
            $table->boolean('phone_null')->default(false);
            $table->boolean('address_null')->default(false);
            $table->boolean('number_address_null')->default(false);

            $table->string('default_commission_type', 2)->default('R$');
            $table->float('fixed_commission_value', 16.2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicel_configs');
    }
};
