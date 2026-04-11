<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // SQLite can't easily alter CHECK constraints,
        // so easiest safe dev fix:
        Schema::table('leases', function (Blueprint $table) {
            // no-op for sqlite (we rely on fresh rebuild OR correct initial schema)
        });
    }

    public function down(): void
    {
        //
    }
};
