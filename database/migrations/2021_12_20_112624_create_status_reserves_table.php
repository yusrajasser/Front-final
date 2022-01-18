<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_reserves', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ride_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('passenger_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reserve_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->float('total_amount', 4, 2);
            // $table->foreign('cancelled_resrvation')->references('id')->on('rides');
            // $table->foreign('history_resrvation')->references('id')->on('rides');
            // $table->foreign('upcoming_resrvation')->references('id')->on('rides');
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
        Schema::dropIfExists('status_reserves');
    }
}
