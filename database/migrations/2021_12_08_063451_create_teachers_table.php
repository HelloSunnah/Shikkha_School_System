<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('link_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('department_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('M_status')->nullable();
            $table->string('salary')->nullable();
            $table->string('Nationality')->default('Bangladesh');
            $table->string('blood_group')->nullable();
            $table->string('shift')->nullable();
            $table->string('address')->nullable();
            $table->string('about')->nullable();
            $table->tinyInteger('active')->default('1');
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->rememberToken();
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
        Schema::dropIfExists('teachers');
        $table->dropSoftDeletes();
    }
}
