<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('nickname');
            $table->string('password');
            $table->boolean('isUser')->default(FALSE);
            
            $table->rememberToken();
            $table->timestamps();
            
            //custom
            $table->tinyInteger('type')->default(3); //0 = root,  1 = manager,  2 = teacher,  3 = normal user
            $table->integer('group')->nullable();
            $table->string('remarks')->nullable();
            $table->string('enable_url')->nullable(); //帳號啟動的鏈結，帳號啟動後會設為空值
            $table->timestampTz('expiry_date')->nullable(); //帳號啟動的鏈結到期時間
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
