<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesForumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies_forum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rep_topic')->unsigned()->nullable();
            $table->integer('rep_by')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('rep_content');
            $table->timestamps('rep_date');

            $table->foreign('rep_topic')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('replies_forum')->onDelete('cascade');
            $table->foreign('rep_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('replies_forum');
    }
}
