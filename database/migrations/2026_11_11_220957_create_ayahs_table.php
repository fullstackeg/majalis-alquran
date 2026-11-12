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
        Schema::create('ayat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('majlis_id')->constrained('majalis')->cascadeOnDelete();
            $table->string('surah_name');
            $table->integer('from_ayah');
            $table->integer('to_ayah');
            $table->text('quranic_text');
            $table->text('bayan_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};
