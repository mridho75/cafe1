<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('tb_users_cafe', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('user_password');
            $table->enum('role', ['admin', 'kasir', 'pemilik']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_users_cafe');
    }

};
