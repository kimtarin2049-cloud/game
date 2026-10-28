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
        if (!Schema::hasTable('game')) {
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->string('topics')->comment('หัวข้อ');
            $table->string('descriptions')->comment('รายละเอียด');
            $table->string('tags')->nullable()->comment('ติด tags');
            $table->string('image1')->nullable()->comment('รูปภาพปกเกม');
            $table->string('image2')->nullable()->comment('รูปภาพเนื้อหาเกม1');
            $table->string('image3')->nullable()->comment('รูปภาพเนื้อหาเกม2');
            $table->decimal('price', 10, 2)->nullable()->comment('ราคา');
            $table->boolean('staem')->default(false)->comment('T=1, F=0');
            $table->boolean('Epic_Games')->default(false)->comment('T=1, F=0');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
