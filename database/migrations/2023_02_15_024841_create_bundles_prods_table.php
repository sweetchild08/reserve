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
        Schema::create('bundles_prods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_id')->constrained('prods');
            $table->foreignId('bundle_id')->constrained('bundles');
            $table->integer('quantity');
            $table->decimal('price_per_unit');
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
        Schema::dropIfExists('bundles_prods');
    }
};
