<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlipTheSwitchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flip_the_switches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->foreignId('image_id')->constrained('images');
            $table->foreignId('media_id')->constrained('media');
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
        Schema::dropIfExists('flip_the_switches');
    }
}
