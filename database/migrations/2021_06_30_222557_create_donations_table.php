<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            $table->string('donor_id')->unique();

            $table->string('donor_name')->nullable();
            $table->string('donor_mail')->nullable();
            $table->string('donation_type')->nullable();
            $table->integer('donor_amount')->default(0);
            $table->string('donor_note')->nullable();
            $table->enum('donor_status', ['pending', 'success', 'failed', 'expired', 'canceled'])->default('pending');
            $table->string('snap_token')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
