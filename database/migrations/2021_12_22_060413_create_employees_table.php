<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name')->nullable();
            $table->string('phone_number')->unique();
            $table->string('employee_id')->unique();
            $table->string('position')->nullable();
            $table->string('image')->nullable();
            $table->string('shift')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('salary')->nullable();
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
        Schema::dropIfExists('employees');
        $table->dropSoftDeletes();

    }
}
