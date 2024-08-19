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
        Schema::create('card_tiles', function (Blueprint $table) { 
            $table->id();
            $table->foreignId('card_id')->constrained();
            $table->tinyInteger('order_number');
            $table->string('randomised_number');
            $table->boolean('marked')->default(false);
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
        Schema::dropIfExists('card_tiles');
    }
};
