<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('catalog_id')->unsigned()->index();
            $table->uuid('uuid')->unique()->index();
            $table->enum('type_entity', ['cpf', 'cnpj', 'noinscription'])->default('noinscription');
            $table->string('inscription')->nullable();
            $table->string('company_name')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('state_registration_abbreviation')->nullable();
            $table->string('city_registration')->nullable();
            $table->string('identity_document')->nullable();
            $table->string('title_electoral')->nullable();
            $table->timestamps();
        });

        Schema::table('catalogs_documents', function ($table) {
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
        Schema::dropIfExists('catalogs_documents');
    }
}
