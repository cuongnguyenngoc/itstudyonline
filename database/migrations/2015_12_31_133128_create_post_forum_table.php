<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostForumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_forum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_topic')->unsigned()->nullable();
            $table->integer('post_by')->unsigned()->nullable();
            $table->string('post_content');
            $table->timestamps('post_date');

            $table->foreign('post_topic')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('post_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_forum');
    }
}
