<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('location');
            $table->string('slug')->unique();
            $table->text('category');
            $table->date('date');
            $table->time('starting_time');
            $table->time('ending_time');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->mediumText('image')->nullable();
            $table->string('organizer')->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('price', 10,2)->nullable();
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
        Schema::dropIfExists('events');
    }
}
