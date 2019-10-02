<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSslResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssl_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('website_id');
            $table->boolean('ssl_valid');
            $table->integer('ssl_expires_in');
            $table->longText('ssl_raw');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ssl_certs');
    }
}
