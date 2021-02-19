<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('balance_id')->constrained();
            $table->foreignId('topup_method_id')->constrained();
            $table->decimal('amount', 36, 18);
            $table->string('transaction_id')->comment('Blockchain transaction id')->nullable()->index();
            $table->tinyInteger('status_id');
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
        Schema::dropIfExists('topups');
    }
}
