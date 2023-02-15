<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('default.jpg');
            $table->foreignId('categories_id')->references('id')->on('categories');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->integer('pax');
            $table->float('rate', 10, 2);
            $table->integer('is_featured');
            $table->integer('is_comments')->default(0)->comment('0 = Enabled | 1 = Disabled');
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
        Schema::dropIfExists('activities');
    }
}
