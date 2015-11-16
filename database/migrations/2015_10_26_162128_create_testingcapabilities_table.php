<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestingcapabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testingcapabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id')->unsigned()->nullable();
            $table->integer('lang_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('lang_id')->references('id')->on('programmingLanguages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('testingcapabilities');
    }
}
