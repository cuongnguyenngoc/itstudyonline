<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersmarklecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersmarklectures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lec_id')->unsigned()->nullable();
            $table->integer('enroll_id')->unsigned()->nullable();
            $table->boolean('isMarked');
            $table->timestamps();

            $table->foreign('lec_id')->references('id')->on('lectures')->onDelete('cascade');
            $table->foreign('enroll_id')->references('id')->on('enrolls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usersmarklectures');
    }
}
