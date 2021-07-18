<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMembersTable extends Migration
{
    public function up()
    {
        Schema::create('report_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cat_id')->nullable()->constrained()->references('id')->on('report_categories')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->string('detail')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_members');
    }
}
