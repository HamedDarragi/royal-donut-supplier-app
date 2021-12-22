<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast_histories', function (Blueprint $table) {
            $table->id();
            $table->date('sending_date');
            $table->time('sending_time');
            $table->unsignedBigInteger('broadcast_group_id');
            $table->foreign('broadcast_group_id')->references('id')->on('broadcast_groups')->onDelete('cascade');
            $table->unsignedBigInteger('broadcast_id');
            $table->foreign('broadcast_id')->references('id')->on('broadcasts')->onDelete('cascade');
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
        Schema::dropIfExists('broadcast_histories');
    }
}
