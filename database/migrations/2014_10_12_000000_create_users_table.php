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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('usertype', ['std', 'teacher', 'admin','parent','super','accountant','proprietor','director','staff'])->default('std');
            $table->string('gender')->nullable();
            $table->foreignId('school_id')->constrained();
            $table->string('login')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('users');
            $table->foreignId('class_id')->nullable()->constrained('classes');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=graduated,1=active,2=suspended,');
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
