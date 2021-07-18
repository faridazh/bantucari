<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('cat_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('case_code')->unique();
            $table->string('slug')->unique();

            $table->enum('status', ['Ditemukan', 'Hilang'])->default('Hilang');
            $table->enum('verify', ['Approved', 'Unapproved'])->default('Unapproved');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
