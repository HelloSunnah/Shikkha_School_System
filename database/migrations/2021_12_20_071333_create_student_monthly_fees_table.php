<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMonthlyFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_monthly_fees', function (Blueprint $table) {
            $table->id();
            $table->string('month_name')->nullable();
            $table->string('month_id')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('status')->default(0);
            $table->integer('paid_amount')->default(0);
            $table->foreignId('fees_type_id')->constrained('fees_types')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
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
        Schema::dropIfExists('student_monthly_fees');
    }
}
