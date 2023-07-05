<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('student_roll_number')->nullable();
            // $table->bigInteger('institute_class_id')->constrained('institute_classes')->cascadeOnDelete();
            $table->foreignId('institute_class_id')->constrained('institute_classes')->cascadeOnDelete();
            $table->integer('section_id');
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('term_id')->constrained('terms')->cascadeOnDelete();
            $table->float('attendance')->default(0);
            $table->float('assignment')->default(0);
            $table->float('class_test')->default(0);
            $table->float('presentation')->default(0);
            $table->float('quiz')->default(0);
            $table->float('practical')->default(0);
            $table->float('written')->default(0);
            $table->float('mcq')->default(0);
            $table->float('others')->default(0);
            $table->float('total')->default(0);
            $table->char('grade')->default(0);
            $table->string('gpa')->default(0);
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
        Schema::dropIfExists('results');
        $table->dropSoftDeletes();
    }
}
