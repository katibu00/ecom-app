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
        Schema::create('monnify_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference');
            $table->string('payment_reference');
            $table->dateTime('paid_on');
            $table->json('payment_source_information');
            $table->json('destination_account_information');
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('settlement_amount', 10, 2);
            $table->string('payment_status');
            $table->string('customer_name');
            $table->string('customer_email');
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
        Schema::dropIfExists('monnify_transfers');
    }
};
