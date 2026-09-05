<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('portfolio_profiles', 'whatsapp_number')) {
            Schema::table('portfolio_profiles', function (Blueprint $table): void {
                $table->string('whatsapp_number')->nullable()->after('phone');
            });
        }

        if (! Schema::hasTable('education')) {
            Schema::create('education', function (Blueprint $table): void {
                $table->id();
                $table->string('level');
                $table->string('institution');
                $table->string('degree')->nullable();
                $table->string('period')->nullable();
                $table->string('result')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_visible')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('education');

        if (Schema::hasColumn('portfolio_profiles', 'whatsapp_number')) {
            Schema::table('portfolio_profiles', function (Blueprint $table): void {
                $table->dropColumn('whatsapp_number');
            });
        }
    }
};
