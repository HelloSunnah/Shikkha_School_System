<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultSubjectCountableMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_subject_countable_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_setting_id');
            $table->foreign('result_setting_id')->references('id')->on('result_settings')->onDelete('cascade');
            $table->unsignedBigInteger('institute_class_id');
            $table->foreign('institute_class_id')->references('id')->on('institute_classes')->onDelete('cascade');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->integer('mcq')->nullable();
            $table->integer('written')->nullable();
            $table->integer('practical')->nullable();
            $table->integer('mark');
            $table->integer("school_id");
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
        Schema::dropIfExists('result_subject_countable_marks');
        $table->dropSoftDeletes();

    }
}
