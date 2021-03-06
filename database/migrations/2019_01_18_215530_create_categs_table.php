<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCategsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_categ');
            $table->string('slug');
            $table->string('descr')->nullable();
            NestedSet::columns($table);
            $table->unique(['parent_id', 'slug']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categs');
    }
}
