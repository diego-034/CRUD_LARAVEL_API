<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('userId');
            $table->string('name',25);
            $table->string('lastName',30);
            $table->string('phone',13);
            $table->string('address',70);
            $table->string('password',100);
            $table->string('email',80);
            $table->unsignedInteger('typeId');
            $table->foreign('typeId')->references('typeId')->on('users_types');
            $table->boolean('state');
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
        Schema::dropIfExists('users');
    }
}
