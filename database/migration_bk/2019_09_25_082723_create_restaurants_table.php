<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('restaurant_name');
            $table->mediumText('image')->nullable();
            $table->string('slug')->unique();
            $table->string('social_link');
            $table->string('location');
            $table->integer('total_capacity');
            $table->integer('tribe_capacity');
            $table->text('day_available');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->text('amenities');
            $table->text('food_beverage')->nullable();
            $table->string('host_name');
            $table->string('host_role');
            $table->string('phone_number');
            $table->string('host_email')->nullable();
            $table->text('info_source')->nullable();
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
        Schema::dropIfExists('restaurants');
    }
}
