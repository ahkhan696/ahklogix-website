<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('apps')
            ->where('slug', 'pricing-calculator')
            ->update(['status' => 'live']);
    }

    public function down(): void
    {
        DB::table('apps')
            ->where('slug', 'pricing-calculator')
            ->update(['status' => 'coming_soon']);
    }
};
