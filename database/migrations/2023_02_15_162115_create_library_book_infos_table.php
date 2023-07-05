<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryBookInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_book_infos', function (Blueprint $table) {
            $table->id();
            $table->string('book_name')->unique();
            $table->string('author_name');
            $table->foreignId('book_type_id')->constrained('lib_book_types')->cascadeOnDelete();
            $table->integer('rack_no');
            $table->string('image');
            $table->integer('quantity');
            $table->integer('available');
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
        Schema::dropIfExists('library_book_infos');
        $table->dropSoftDeletes();

    }
}
