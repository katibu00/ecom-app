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
        Schema::create('c_a_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('desc');
            $table->integer('marks');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('school_id');
            $table->string('class_id');
        
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
        Schema::dropIfExists('c_a_schemes');
    }
};
