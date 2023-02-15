<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('email');
            $table->string('contact');
            // $table->string('nationality');
            // $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('address');
            $table->string('username');
            $table->string('password');
            $table->integer('is_active');
            $table->integer('recovery_code');
            $table->integer('roles')->comment('0 = Administrator | 1 = Customer');
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
        Schema::dropIfExists('users');
    }
}
