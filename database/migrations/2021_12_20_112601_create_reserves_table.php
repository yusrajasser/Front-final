<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('passenger_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->integer('num_of_seats_reserved');
            $table->string('occurance')->default('once');
            $table->date('once_date')->nullable();
            $table->string('multi_dates')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('reserves');
    }
}
