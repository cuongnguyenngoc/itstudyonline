<?php

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
            $table->integer('role_id')->unsigned()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fullname');
            $table->string('biography')->nullable();
            $table->string('address')->nullable();
            $table->string('links')->nullable();
            $table->string('expert')->nullable();
            $table->date('birth')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('userRoles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
