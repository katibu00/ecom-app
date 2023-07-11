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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('session_id');
            $table->string('term');
            $table->date('date');
            $table->unsignedBigInteger('payer_id');
            $table->unsignedBigInteger('payee_id')->nullable();
            $table->unsignedBigInteger('expense_category_id');
            $table->string('description');
            $table->integer('number');
            $table->double('amount');
            $table->tinyInteger('status')->default(0);
        
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('payer_id')->references('id')->on('users');
            $table->foreign('payee_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
