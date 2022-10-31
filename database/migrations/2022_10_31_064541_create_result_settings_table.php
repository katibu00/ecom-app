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
        Schema::create('result_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('school_id');
            $table->tinyInteger('show_position')->default(1);
            $table->tinyInteger('show_attendance')->default(1);
            $table->tinyInteger('show_passport')->default(1);
            $table->tinyInteger('withhold')->default(0);
            $table->integer('minimun_amount')->nullable();
            $table->string('grading_style')->default('waec');
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
        Schema::dropIfExists('result_settings');
    }
};
