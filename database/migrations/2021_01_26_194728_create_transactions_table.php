<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wallet_no');
            $table->double('amount');
            $table->string('description');
            $table->string('transaction_type');
            $table->enum('transaction_status', ['Pending', 'Failed', 'Success'])->default('Pending');
            $table->string('phone');
            $table->text('reference');
            $table->text('reason');
            
            $table->timestamps();

            $table->foreign('wallet_no')->references('wallet_no')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
