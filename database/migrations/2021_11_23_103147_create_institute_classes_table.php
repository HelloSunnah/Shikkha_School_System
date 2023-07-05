<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name')->nullable();
            $table->string('class_name_bn')->nullable();
            $table->string('class_fees')->nullable();
            $table->string('active')->nullable();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('institute_classes');
        $table->dropSoftDeletes();

    }
}
