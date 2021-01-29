<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('days', function (Blueprint $table) {
            $table->bigInteger('restaurant_id')->unsigned()->after('id');
            $table->string('day_of_week')->after('restaurant_id');
            $table->time('opening_time')->after('day_of_week');
            $table->time('closing_time')->after('opening_time');

            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('days', function (Blueprint $table) {
            $table->dropColumn('restaurant_id');
            $table->dropColumn('day_of_week');
            $table->dropColumn('opening_time');
            $table->dropColumn('closing_time');
        });
    }
}
