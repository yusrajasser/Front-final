<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->string('from');
            $table->string('to');
            $table->integer('actual_reservation_nums')->nullable();
            // $table->date('date');
            $table->time('time');
            // $table->float('amount', 4, 2);
            $table->string('occurance')->default('once');
            $table->date('once_date')->nullable();
            $table->string('multi_date')->nullable();
            $table->boolean('waitting')->default(0);
            $table->string('status')->default('waiting');
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
        Schema::dropIfExists('rides');
    }
}
