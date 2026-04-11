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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();

            // tenant who reported issue
            $table->foreignId('tenant_id')
                ->constrained('users')
                ->onDelete('cascade');

            // apartment where issue happened
            $table->foreignId('apartment_id')
                ->constrained('apartments')
                ->onDelete('cascade');

            $table->string('title');
            $table->text('description');

            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            $table->enum('status', ['open', 'in_progress', 'resolved', 'rejected'])
            ->default('open');

            $table->string('photo_path')->nullable();

            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
