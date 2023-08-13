<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodolistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todolists', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->string('date')->default(0);
            $table->string('reminder_message')->nullable();
            $table->string('reminder_date')->default(0);
            $table->string('reminder_time')->default(0);
            $table->string('status')->default(3);
            $table->string('status_for_school')->default(0);
            $table->foreignId('school_id')->constrained('schools')->nullable();
            $table->integer('priority')->default(3);
            $table->string('attachment')->nullable();
            $table->string('command')->nullable();
            $table->foreignId('assign_teacher_id')->nullable();
            $table->foreignId('teacher_id')->nullable();
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
        Schema::dropIfExists('todolists');
    }
}
