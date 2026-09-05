<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_profiles', function (Blueprint $table): void {
            $table->text('professional_roles')->nullable()->after('title');
        });

        DB::table('portfolio_profiles')->whereNull('professional_roles')->update([
            'professional_roles' => "Software Engineer\nPHP & Laravel Developer",
        ]);
    }

    public function down(): void
    {
        Schema::table('portfolio_profiles', function (Blueprint $table): void {
            $table->dropColumn('professional_roles');
        });
    }
};
