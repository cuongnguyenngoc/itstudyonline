<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id')->unsigned()->nullable();
            $table->integer('lang_id')->unsigned()->nullable();
            $table->integer('level_id')->unsigned()->nullable();
            
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->float('cost');
            $table->boolean('isPublic');
            $table->integer('shares');
            $table->integer('views');

            $table->timestamps();
            
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('lang_id')->references('id')->on('programmingLangugages')->onDelete('set null');
            $table->foreign('level_id')->references('id')->on('learningLevels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
