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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('form_master_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('section_id');
            $table->tinyInteger('status')->default(1);
        
            $table->foreign('form_master_id')->references('id')->on('users');
            $table->foreign('school_id')->references('id')->on('schools');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
