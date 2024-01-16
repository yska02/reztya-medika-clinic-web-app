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
        Schema::create('delivery_infos', function (Blueprint $table) {
            $table->id('delivery_info_id');
            $table->string('delivery_destination', 255);
            $table->string('delivery_type', 255);
            $table->string('estimated_days', 255);
            $table->integer('weight');
            $table->integer('delivery_fee')->length(11);
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
        Schema::dropIfExists('delivery_infos');
    }
};
