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
        Schema::create('technicel_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technicel_commission_id');

            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->unsignedBigInteger('owner_id');

            $table->foreign('technical_id')->on('technicals')->references('technical_id')->cascadeOnDelete();
            $table->unsignedBigInteger('technical_id');
            
            $table->string('technical_name', 120);
            $table->float('commission_value', 16.2);
            $table->string('commission_type', 2)->default('R$');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicel_commissions');
    }
};
