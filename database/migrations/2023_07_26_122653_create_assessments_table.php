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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('title');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedInteger('mark_percentage')->nullable();
            $table->integer('duration')->nullable();
            $table->string('classes')->nullable();
            $table->enum('status', ['scheduled', 'not_scheduled'])->default('not_scheduled');
            $table->date('date')->nullable();
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->enum('num_questions', ['all', '10', '15', '20', '25', '30', '35', '40', '50', '60', '70', '100'])->nullable();
            $table->enum('attempt_limit', ['unlimited', '1', '2', '3'])->nullable();
            $table->enum('show_result', ['yes', 'no'])->nullable();
            $table->timestamps();
            
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
