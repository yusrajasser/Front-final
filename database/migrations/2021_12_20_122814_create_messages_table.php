<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ride_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('passenger_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');

            $table->text('message');
            $table->string('messages_notify_by')->default('email');

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
        Schema::dropIfExists('messages');
    }
}
