<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('catalog_id')->unsigned()->index();
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_sms_verified_at')->nullable();
            $table->timestamp('phone_whatsapp_verified_at')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
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
        Schema::dropIfExists('users');
    }
}
