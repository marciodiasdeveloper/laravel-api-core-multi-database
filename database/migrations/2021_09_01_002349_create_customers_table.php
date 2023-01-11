<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('catalog_id')->unsigned()->index();
            $table->uuid('uuid')->unique()->index();
            $table->string('email');
            $table->string('branch_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('occupation_area')->nullable();
            $table->integer('employees_number')->nullable();
            $table->text('observations')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });

        Schema::table('customers', function ($table) {
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
        Schema::dropIfExists('customers');
    }
}
