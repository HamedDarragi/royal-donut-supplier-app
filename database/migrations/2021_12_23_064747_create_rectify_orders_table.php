<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRectifyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rectify_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('supplier_name');
            $table->string('order_no');
            $table->string('order_number');
            $table->string('order_status');
            $table->integer('item_count');
            $table->integer('total');
            $table->string('discount');
            $table->string('taxes');
            $table->string('grand_total');
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
        Schema::dropIfExists('rectify_orders');
    }
}
