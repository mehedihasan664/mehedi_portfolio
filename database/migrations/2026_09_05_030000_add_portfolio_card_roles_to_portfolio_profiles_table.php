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
            $table->text('portfolio_card_roles')->nullable()->after('professional_roles');
        });

        DB::table('portfolio_profiles')->whereNull('portfolio_card_roles')->update([
            'portfolio_card_roles' => "Full Stack Developer\nPHP & Laravel Developer",
        ]);
    }

    public function down(): void
    {
        Schema::table('portfolio_profiles', function (Blueprint $table): void {
            $table->dropColumn('portfolio_card_roles');
        });
    }
};
