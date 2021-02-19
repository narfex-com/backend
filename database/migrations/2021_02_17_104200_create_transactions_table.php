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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('from_currency_id')->nullable();
            $table->unsignedBigInteger('to_currency_id')->nullable();
            $table->unsignedBigInteger('from_balance_id')->nullable();
            $table->unsignedBigInteger('to_balance_id')->nullable();
            $table->morphs('typeable');
            $table->decimal('amount', 36, 18);
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
        Schema::dropIfExists('transactions');
    }
}
