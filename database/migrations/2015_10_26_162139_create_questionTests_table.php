<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionTests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id')->unsigned()->nullable();
            $table->integer('quiz_id')->unsigned()->nullable();
            $table->string('content');
            $table->char('right_alphabet',1);
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('testingcapabilities')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizExams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questionTests');
    }
}
