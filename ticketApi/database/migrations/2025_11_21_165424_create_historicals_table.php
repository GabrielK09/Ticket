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
        Schema::create('historicals', function (Blueprint $table) {
            $table->id();
            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->foreign('customer_id')->references('customer_id')->on('customers')->cascadeOnDelete();
            $table->foreign('techinical_id')->references('techinical_id')->on('techinicals')->cascadeOnDelete();

            $table->longText('description');
            $table->unsignedBigInteger('customer_id'); 
            $table->string('customer', 120);

            $table->unsignedBigInteger('owner_id'); 
            $table->string('enterprise', 120);

            $table->unsignedBigInteger('techinical_id'); 
            $table->string('techinical', 120);

            $table->string('old_status', 30)->nullable();
            $table->string('new_status', 30)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicals');
    }
};
