<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('cat_name')->unique();

            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'CategorySeeder'));
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
