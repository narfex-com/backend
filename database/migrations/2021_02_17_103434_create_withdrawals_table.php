<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('balance_id')->constrained();
            $table->string('withdrawal_method');
            $table->decimal('amount', 36, 18);
            $table->tinyInteger('status_id')->index();
            $table->string('transaction_id')->comment('Blockchain transaction id')->nullable()->index();
            $table->string('declined_reason')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
