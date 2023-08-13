<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_models', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('feature_id');
            $table->string('image');
            $table->double('price')->default('0');
            $table->string('button');
            $table->string('status');
            $table->string('description');
            $table->string('longdescription');
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
        Schema::dropIfExists('addon_models');
    }
}
