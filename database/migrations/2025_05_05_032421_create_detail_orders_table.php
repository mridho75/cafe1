<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('tb_detail_orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_order');
        $table->unsignedBigInteger('id_menu');
        $table->integer('qty');
        $table->decimal('harga_satuan', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();

        $table->foreign('id_order')->references('id')->on('tb_orders')->onDelete('cascade');
        $table->foreign('id_menu')->references('id')->on('tb_menus')->onDelete('cascade');
    });

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_orders');
    }
};
