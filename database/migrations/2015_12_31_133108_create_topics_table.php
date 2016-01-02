<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enroll_id')->unsigned()->nullable();
            $table->integer('topic_cat')->unsigned()->nullable();
            $table->integer('topic_by')->unsigned()->nullable();
            $table->string('topic_subject');
            $table->timestamps('topic_date');

            $table->foreign('enroll_id')->references('id')->on('enrolls')->onDelete('set null');
            $table->foreign('topic_cat')->references('id')->on('categories_forum')->onDelete('set null');
            $table->foreign('topic_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics');
    }
}
