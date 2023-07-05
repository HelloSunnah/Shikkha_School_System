<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Transection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transections', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('purpose');
            $table->string('payment_method');
            $table->double('amount');
            $table->tinyInteger('type');
            $table->string('remark')->nullable();
            $table->string('name'); 
            $table->timestamp('datee')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('transections');
        $table->dropSoftDeletes();

    }
}
