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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->index();
            $table->uuid('ticket_code')->index();
            
            $table->foreign('owner_id')->references('id')->on('owners')->cascadeOnDelete();
            $table->unsignedBigInteger('owner_id');

            $table->unique(['ticket_code', 'owner_id']);
            $table->foreign('customer_id')->references('customer_id')->on('customers')->cascadeOnDelete();

            $table->string('title', 60);
            $table->longText('description');
            $table->string('priority', 20);

            $table->string('location', 40)->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer', 120);

            $table->float('location_value', 16.2); // Para casos de houver taxa de ir até o local
            
            $table->float('increase_value', 16.2);
            $table->string('increase_tpye', 2);

            $table->float('discount_value', 16.2);
            $table->string('discount_type', 2);

            $table->float('base_value', 16.2);
            $table->float('total_value', 16.2);

            $table->boolean('in_progress')->default(0);
            $table->boolean('finish')->default(0);
            $table->boolean('canceled')->default(0);
            $table->string('status', 30)->default('Pendente');
            $table->timestamp('date_paid')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
