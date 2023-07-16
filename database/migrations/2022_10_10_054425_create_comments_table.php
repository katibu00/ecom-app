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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('session_id');
            $table->string('term');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('student_id');
            $table->string('officer');
            $table->string('comment')->nullable();
            $table->string('additional')->nullable();
            $table->timestamps();
        
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('student_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
