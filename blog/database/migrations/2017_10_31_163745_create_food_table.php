<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //0=共用
//             $table->foreign('user_id')
//             ->references('id')->on('users')
//             ->onDelete('cascade');
            
            $table->integer('category');
            $table->string('category_name');
            $table->string('name');
            $table->float('weight');
            $table->string('unit');
            $table->float('sugar_gram');
            $table->float('kcal');
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
        Schema::dropIfExists('food');
    }
}
