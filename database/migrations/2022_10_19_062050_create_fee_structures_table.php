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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->string('term');
            $table->unsignedBigInteger('fee_category_id');
            $table->string('student_type');
            $table->double('amount');
            $table->string('priority');
        
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('fee_category_id')->references('id')->on('fee_categories');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_structures');
    }
};
