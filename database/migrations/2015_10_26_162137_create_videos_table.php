<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lec_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('video_name');
            $table->string('path');
            $table->integer('thumb_id')->unsigned()->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('lec_id')->references('id')->on('lectures')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
