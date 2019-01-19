<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_news');
            $table->string('slug');
            $table->text('body_news');
            $table->integer('categ_id')->unsigned();
            $table->foreign('categ_id')->references('id')->on('categs')->onDelete('CASCADE');
            $table->unique(['categ_id', 'slug']);
            $table->unique(['categ_id', 'name_news']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
