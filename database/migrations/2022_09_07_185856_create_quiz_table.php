<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_courses');
            $table->integer('id_teacher');
            $table->integer('id_matter');
            $table->text('title');            
            $table->text('alternative_1');
            $table->text('alternative_2');
            $table->text('alternative_3');
            $table->text('alternative_4');
            $table->text('answer');
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
        Schema::dropIfExists('quiz');
    }
}
