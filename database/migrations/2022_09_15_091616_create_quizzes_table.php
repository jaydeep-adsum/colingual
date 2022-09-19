<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->text('question1');
            $table->string('option1A');
            $table->string('option1B');
            $table->string('option1C');
            $table->string('option1D');
            $table->string('answer1');
            $table->text('question2');
            $table->string('option2A');
            $table->string('option2B');
            $table->string('option2C');
            $table->string('option2D');
            $table->string('answer2');
            $table->text('question3');
            $table->string('option3A');
            $table->string('option3B');
            $table->string('option3C');
            $table->string('option3D');
            $table->string('answer3');
            $table->text('question4');
            $table->string('option4A');
            $table->string('option4B');
            $table->string('option4C');
            $table->string('option4D');
            $table->string('answer4');
            $table->text('question5');
            $table->string('option5A');
            $table->string('option5B');
            $table->string('option5C');
            $table->string('option5D');
            $table->string('answer5');
            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
