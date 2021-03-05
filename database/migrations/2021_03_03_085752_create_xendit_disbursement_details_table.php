<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXenditDisbursementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xendit_disbursement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('withdrawal_id');
            $table->string('bank_code');
            $table->string('account_holder_name');
            $table->string('account_number');
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
        Schema::dropIfExists('xendit_disbursement_details');
    }
}
