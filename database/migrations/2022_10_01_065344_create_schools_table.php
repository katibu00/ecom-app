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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('motto')->nullable();
            $table->string('username');
            $table->string('state')->nullable();
            $table->string('lga')->nullable();;
            $table->string('address');
            $table->string('phone_first');
            $table->string('phone_second')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('term')->nullable();
            $table->string('heading')->default('h2');
            $table->unsignedBigInteger('registrar_id')->nullable();
            $table->unsignedBigInteger('admin_id');

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('schools');
    }
};
