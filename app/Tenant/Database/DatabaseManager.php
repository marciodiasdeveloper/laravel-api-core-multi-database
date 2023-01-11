<?php

namespace App\Tenant\Database;

use App\Models\Tenant\Tenant;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function createDatabase(Tenant $tenant)
    {
        if(app()->environment() !== 'testing') {
            DB::statement("CREATE DATABASE {$tenant->database->db_database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        return true;
    }

    public function dropDatabase(Tenant $tenant)
    {
        if(app()->environment() !== 'testing') {
            DB::statement("DROP DATABASE {$tenant->database->db_database}");
        }

        return true;
    }
}
