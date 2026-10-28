<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('game', function (Blueprint $table) {
            // เพิ่มคอลัมน์ steam_app_id (ให้เก็บเป็น string เผื่อบางเกมมีตัวหนังสือ หรือเว้นว่างได้ถ้าเกมนั้นไม่มีบน Steam)
            $table->string('steam_app_id')->nullable()->after('topics'); 
        });
    }

    public function down(): void
    {
        Schema::table('game', function (Blueprint $table) {
            $table->dropColumn('steam_app_id');
        });
    }
};
