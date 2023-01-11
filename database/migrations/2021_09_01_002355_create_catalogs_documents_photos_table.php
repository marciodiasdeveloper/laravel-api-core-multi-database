<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsDocumentsPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs_documents_photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('catalog_id')->unsigned();
            $table->bigInteger('catalog_document_id')->unsigned();
            $table->uuid('uuid')->unique();
            $table->enum('type', ['back', 'front', 'selfie'])->default('selfie');
            $table->timestamps();
        });

        Schema::table('catalogs_documents_photos', function ($table) {
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
            $table->foreign('catalog_document_id')->references('id')->on('catalogs_documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs_documents_photos');
    }
}
