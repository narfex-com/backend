<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('from_balance_id');
            $table->unsignedBigInteger('to_balance_id');
            $table->unsignedBigInteger('from_currency_id');
            $table->unsignedBigInteger('to_currency_id');
            $table->decimal('rate', 36, 18);
            $table->decimal('from_amount', 36, 18);
            $table->decimal('to_amount', 36, 18);
            $table->tinyInteger('status_id');
            $table->string('declined_reason')->nullable();
            $table->timestamps();

            $table->foreign('from_balance_id')->references('id')->on('balances');
            $table->foreign('to_balance_id')->references('id')->on('balances');
            $table->foreign('from_currency_id')->references('id')->on('currencies');
            $table->foreign('to_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
