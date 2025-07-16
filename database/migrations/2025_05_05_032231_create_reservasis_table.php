<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('tb_users_cafe')->onDelete('cascade');
            $table->foreignId('id_member')->nullable()->constrained('tb_members')->onDelete('set null');
            $table->string('nama_pelanggan');
            $table->date('tanggal_dibuat');
            $table->date('tanggal_reservasi');
            $table->string('nomor_meja');
            $table->integer('jumlah_kursi');
            $table->decimal('dp', 10, 2);
            $table->boolean('sudah_dipakai')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_reservasis');
    }
};
