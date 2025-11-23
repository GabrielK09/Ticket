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
        Schema::create('pay_ment_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pay_ment_ticket_id')->index();
            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();

            $table->unsignedBigInteger('owner_id'); 
            $table->string('enterprise', 120);
            $table->float('amount_paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_ment_tickets');
    }
};
