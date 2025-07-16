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
        Schema::create('tb_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_reservasi')->nullable()->constrained('tb_reservasis')->onDelete('set null');
            $table->foreignId('id_user')->constrained('tb_users_cafe')->onDelete('cascade');
            $table->foreignId('id_member')->nullable()->constrained('tb_members')->onDelete('set null');
            $table->foreignId('id_metode_pembayaran')->nullable()->constrained('tb_metode_pembayaran')->onDelete('set null');
            $table->date('tgl');
            $table->decimal('total_harga', 10, 2);
            $table->decimal('jml_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_orders');
    }
};
