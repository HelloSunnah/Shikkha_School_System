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
            $table->string('type');
            $table->bigInteger('school_id');
            // $table->bigInteger('term_id');
            $table->foreignId('term_id')->constrained('terms')->cascadeOnDelete();
            $table->bigInteger('class_id');
            $table->bigInteger('subject_id');
            $table->string('hours');
            $table->string('total_marks');
            $table->string('question_title')->nullable();
            $table->longText('mcq_question')->nullable();
            $table->longText('cre_question')->nullable();
            $table->string('question_mark')->nullable();
            $table->longText('question')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        $table->dropSoftDeletes();

    }
}
