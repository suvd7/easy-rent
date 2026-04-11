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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();

            // FK → properties
            $table->foreignId('property_id')
                ->constrained('properties')
                ->onDelete('cascade');

            $table->string('unit_number');
            $table->integer('floor');

            $table->decimal('rent_amount', 10, 2);

            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('size_sqm');

            $table->boolean('has_parking')->default(false);
            $table->boolean('is_available')->default(true);

            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
