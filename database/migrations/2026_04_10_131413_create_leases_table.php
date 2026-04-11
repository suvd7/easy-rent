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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();

            // tenant (user)
            $table->foreignId('tenant_id')
                ->constrained('users')
                ->onDelete('cascade');

            // apartment being rented
            $table->foreignId('apartment_id')
                ->constrained('apartments')
                ->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');

            $table->decimal('monthly_rent', 10, 2);

           $table->enum('status', ['active', 'ended'])->default('active');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
