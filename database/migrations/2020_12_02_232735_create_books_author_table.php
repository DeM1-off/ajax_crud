<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_to_autors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('book_id')->nullable(false);
            $table->unsignedBigInteger('author_id')->nullable(false);
            $table->timestamps();

        });
        Schema::table('books_to_autors', function (Blueprint $table) {

            $table->foreign('book_id')->references('book_id')->on('books')->onDelete('CASCADE');
            $table->foreign('author_id')->references('author_id')->on('authors')->onDelete('CASCADE');

        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books_to_autors', function (Blueprint $table) {
        $table->dropForeign('book_id');
        $table->dropForeign('author_id');
    });
        Schema::dropIfExists('books_author');
    }
}
