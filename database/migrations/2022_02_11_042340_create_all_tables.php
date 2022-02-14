<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('password');
        });

        Schema::create('products_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser');
            $table->string('name');
            $table->string('descricao')->nullable();
            $table->string('img')->nullable();
            $table->double('preco')->nullable();
            $table->string('tags');
            $table->integer('qtdTags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('products_tags');
    }
};
