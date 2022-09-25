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
        Schema::create('t_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name',60)->default('')->comment('用户名');
            $table->string('pass_word',60)->default('')->comment('密码');
            $table->timestamps();
            $table->index('user_name','idx_c2');
            $table->comment('后台-登陆用户表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_users');
    }
};
