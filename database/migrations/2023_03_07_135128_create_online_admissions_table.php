<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('dob');
            $table->string('f_name');
            $table->string('f_occupation')->nullable();
            $table->string('f_nid')->nullable();
            $table->string('f_phone')->nullable();
            $table->string('m_name');
            $table->string('m_occupation')->nullable();
            $table->string('m_phone')->nullable();
            $table->string('m_nid')->nullable();
            $table->string('gender');
            $table->string('blood_group')->nullable();
            $table->string('religion');
            $table->string('nationality')->nullable();

          

            $table->string('pre_address')->nullable();
            $table->string('par_address')->nullable();
            $table->string('income')->nullable();

            $table->string('g_name')->nullable();
            $table->string('g_phone')->nullable();
            $table->string('relation')->nullable();

            $table->string('old_school')->nullable();
            $table->string('In_class')->nullable();
            $table->string('group')->nullable();
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
        Schema::dropIfExists('online_admissions');
        $table->dropSoftDeletes();

    }
}
