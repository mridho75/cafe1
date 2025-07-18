<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tb_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_category')->constrained('tb_categories')->onDelete('cascade');
            $table->string('nama_menu');
            $table->decimal('harga', 10, 2);
            $table->string('image')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_menus');
    }
};

