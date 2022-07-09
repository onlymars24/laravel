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
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('Отошёл')->nullable();
            $table->string('name')->default(null)->nullable();
            $table->string('position')->default(null)->nullable();
            $table->string('img')->default('avatars/avatar-m.png');
            $table->string('phone')->default(null)->nullable();
            $table->string('address')->default(null)->nullable();
            $table->string('vk')->default('https://vk.com/');
            $table->string('telegram')->default('https://telegram.org/');
            $table->string('instagram')->default('https://www.instagram.com/');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
