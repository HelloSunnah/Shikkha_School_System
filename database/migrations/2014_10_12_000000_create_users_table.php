<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('roll_number')->unique();
            $table->string('phone')->unique();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('discount')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('image')->nullable();
            $table->text('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('class_id')->constrained('institute_classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->integer('group_id')->nullable();
            $table->integer('scholarship')->default(1);
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->tinyInteger('shift')->default(2)->comment('1=morning, 2=day, 3=eveing');
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
        Schema::dropIfExists('users');
        $table->dropSoftDeletes();
    }
}
