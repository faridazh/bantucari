<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id();

            $table->string('cat_name');
            $table->enum('cat_for', ['Laporan', 'Member', 'Both'])->default('Both');

            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'ReportCat'));
    }

    public function down()
    {
        Schema::dropIfExists('report_categories');
    }
}
