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
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id('payment_receipt_id');
            $table->date('payment_date');
            $table->integer('payment_amount')->length(11);
            $table->string('payment_method', 15);
            $table->string('account_number', 20)->nullable();
            $table->string('account_name', 255)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->string('confirmed_by', 255)->nullable();
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
        //
    }
};
