<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporsTable extends Migration
{
    public function up()
    {
        Schema::create('pelapors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->nullable()->constrained()->references('id')->on('posts')->onDelete('cascade');

            $table->string('case_code')->unique();
            $table->foreign('case_code')->unique()->constrained()->references('case_code')->on('posts')->onUpdate('cascade')->onDelete('cascade');

            $table->string('nama_pelapor')->nullable();
            $table->char('hubungi_pelapor', 15)->nullable();
            $table->string('email_pelapor')->nullable();
            $table->string('alamat_pelapor', 1000)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelapors');
    }
}
