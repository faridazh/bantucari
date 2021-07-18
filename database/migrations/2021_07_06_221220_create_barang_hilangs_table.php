<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHilangsTable extends Migration
{
    public function up()
    {
        Schema::create('barang_hilangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->nullable()->constrained()->references('id')->on('posts')->onDelete('cascade');

            $table->string('case_code')->unique();
            $table->foreign('case_code')->unique()->constrained()->references('case_code')->on('posts')->onUpdate('cascade')->onDelete('cascade');

            $table->string('fullname');
            $table->json('photo');
            $table->date('tanggal')->nullable();
            $table->enum('jenis', ['Barang Pribadi', 'Dokumen', 'Smartphone', 'Lainnya'])->default('Lainnya');
            $table->string('tempatakhir', 500)->nullable();
            $table->string('ciri', 500)->nullable();
            $table->string('kronologi', 500)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_hilangs');
    }
}
