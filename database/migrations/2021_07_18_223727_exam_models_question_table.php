<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExamModelsQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_models_question', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_models_id')->constrained('exam_models')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('weight')->nullable(false);
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
        //
    }
}
