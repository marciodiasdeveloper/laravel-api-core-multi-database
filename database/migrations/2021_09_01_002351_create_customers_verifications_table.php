<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_verifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('customer_id')->unsigned();
            $table->enum('method', ['email', 'sms', 'whatsapp', 'call']);
            $table->enum('type', ['personal', 'company']);
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });

        Schema::table('customers_verifications', function ($table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_verifications');
    }
}
