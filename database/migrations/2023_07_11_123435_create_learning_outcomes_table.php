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
        Schema::create('learning_outcomes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('learning_domain_id');
            $table->unsignedBigInteger('school_id');

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('learning_domain_id')->references('id')->on('learning_domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_outcomes');
    }
};
