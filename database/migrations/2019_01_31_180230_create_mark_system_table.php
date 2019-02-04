<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_system', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id')->unsigned()->nullable();
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->text('question_info')->nullable();
            $table->text('mark_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mark_system');
    }
}
