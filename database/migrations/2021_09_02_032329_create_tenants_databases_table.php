<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants_databases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->index();
            $table->string('uuid');
            $table->enum('type', ['mysql'])->default('mysql');
            $table->string('db_database');
            $table->string('db_host');
            $table->string('db_username');
            $table->string('db_password');
            $table->integer('db_port');
            $table->timestamps();
        });

        Schema::table('tenants_databases', function ($table) {
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants_databases');
    }
}
