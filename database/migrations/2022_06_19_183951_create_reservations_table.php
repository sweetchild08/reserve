<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('users');
            $table->longText('description');
            $table->string('booking_type');
            $table->integer('booking_id');
            $table->string('payment_type');
            $table->integer('amount');
            $table->string('date_from');
            $table->string('date_to');
            $table->string('reference');
            $table->string('status')->comment('Paid | Unpaid');
            $table->string('booking_status')->comment('Pending | Approved | Completed');
            $table->integer('is_order')->comment('0 = Online Booking | 1 = Offline Booking')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
