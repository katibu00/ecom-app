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
            $table->string('state');
            $table->string('lga');
            $table->string('address');
            $table->integer('service_fee'); 
            $table->string('phone_first');
            $table->string('phone_second')->nullable();
            $table->string('email')->nullable();
            $table->string('website');
            $table->string('logo')->default('default.png');
            $table->integer('session_id')->nullable();
            $table->string('term')->nullable();
            $table->string('show_position')->default('on')->nullable();
            $table->string('show_attendance')->default('on')->nullable();
            $table->string('show_passport')->default('on')->nullable();
            $table->string('grading')->default('waec');
            $table->string('heading')->default('h2');
            $table->integer('registrar_id');
            $table->integer('admin_id')->nullable();
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
