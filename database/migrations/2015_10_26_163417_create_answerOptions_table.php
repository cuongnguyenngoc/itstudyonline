<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answerOptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('que_id')->unsigned()->nullable();
            $table->char('alphabet',1);
            $table->string('content');
            $table->timestamps();

            $table->foreign('que_id')->references('id')->on('questionTests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answerOptions');
    }
}
