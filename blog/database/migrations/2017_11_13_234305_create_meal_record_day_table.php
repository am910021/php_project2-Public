<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealRecordDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_record_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            
            $table->date('date');
            $table->float('calories'); // 熱量 /大卡
            $table->float('weight');   // 糖 / 公克

            $table->float('percent')->unsigned();

            $table->integer('age')->unsigned();
            $table->float('height')->unsigned();           // 身高
            $table->float('p_weight')->unsigned();         // 體重
            $table->integer('activity_amount')->unsigned();
            $table->float('rc')->unsigned(); //Recommended calories

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
        Schema::dropIfExists('mealRecordDay');
    }
}
