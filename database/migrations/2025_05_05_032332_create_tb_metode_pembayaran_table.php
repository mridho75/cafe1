<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_metode');
            $table->string('ikon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_metode_pembayaran');
    }
};
