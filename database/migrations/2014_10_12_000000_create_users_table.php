<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->unique();
            $table->enum('role', ['Admin','Moderator','Staff','Member','Banned'])->default('Member');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birthdate');
            $table->char('phone', 15)->nullable();
            $table->string('avatar', 500)->nullable();
            $table->string('address', 1000)->nullable();
            $table->enum('states', ['Aceh', 'Bali', 'Banten', 'Bengkulu', 'Gorontalo', 'Jakarta', 'Jambi', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Timur', 'Kalimantan Utara', 'Kepulauan Bangka Belitung', 'Kepulauan Riau', 'Lampung', 'Maluku', 'Maluku Utara', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Papua', 'Papua Barat', 'Provinsi Kalimantan Selatan', 'Provinsi Sulawesi Selatan', 'Riau', 'Sulawesi Barat', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara', 'Yogyakarta'])->nullable();
            $table->string('zipcode', 5)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'UserSeeder'));
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
