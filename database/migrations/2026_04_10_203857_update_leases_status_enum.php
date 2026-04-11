<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite doesn't support ALTER COLUMN so we recreate the constraint
        // by rebuilding the table data — simplest fix is just update via raw SQL
        DB::statement('PRAGMA foreign_keys=OFF');
        DB::statement("CREATE TABLE leases_new AS SELECT * FROM leases");
        DB::statement("DROP TABLE leases");
        DB::statement("CREATE TABLE leases (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tenant_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            apartment_id INTEGER NOT NULL REFERENCES apartments(id) ON DELETE CASCADE,
            start_date DATE NOT NULL,
            end_date DATE NOT NULL,
            monthly_rent DECIMAL(10,2) NOT NULL,
            status VARCHAR CHECK(status IN ('active','ended','expired','terminated')) NOT NULL DEFAULT 'active',
            notes TEXT,
            created_at DATETIME,
            updated_at DATETIME
        )");
        DB::statement("INSERT INTO leases SELECT * FROM leases_new");
        DB::statement("DROP TABLE leases_new");
        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        // not needed
    }
};