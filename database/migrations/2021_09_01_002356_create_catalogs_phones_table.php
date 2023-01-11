<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs_phones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('catalog_id')->unsigned()->index();
            $table->uuid('uuid')->unique();
            $table->enum('phone_type', ['personal', 'company'])->default('personal');
            $table->string('phone_number');
            $table->timestamps();
        });

        Schema::table('catalogs_phones', function ($table) {
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs_phones');
    }
}
