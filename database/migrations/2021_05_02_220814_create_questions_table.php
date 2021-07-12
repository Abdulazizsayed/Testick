<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('type', ['Parent', 'T/F', 'SSMCQ', 'MSMCQ', 'Essay', 'Text Check']);
            $table->enum('difficulty', ['Easy', 'Med', 'Hard']);
            $table->string('chapter');

            $table->foreignId('parent_id')->nullable()->constrained('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('question_bank_id')->nullable()->constrained('question_banks')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('questions');
    }
}
