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
        Schema::create('psychomotor_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('session_id');
            $table->string('term');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('student_id');
            $table->string('type');
            $table->unsignedBigInteger('grade_id');
            $table->integer('score');
            $table->timestamps();
        
            $table->foreign('school_id')->references('id')->on('schools');
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
        Schema::dropIfExists('psychomotor_grades');
    }
};
