<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersVerificationsSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_verifications_sends', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('customer_verification_id')->unsigned();
            $table->string('secret_code');
            $table->string('contact_value');
            $table->timestamps();
        });

        Schema::table('customers_verifications_sends', function ($table) {
            $table->foreign('customer_verification_id')->references('id')->on('customers_verifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_verifications_logs');
    }
}
