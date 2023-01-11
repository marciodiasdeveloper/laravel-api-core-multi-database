<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('customer_id')->unsigned();
            $table->enum('type', ['trial', 'week', 'month', 'year'])->default('trial');
            $table->timestamp('trial_ends_at');
            $table->timestamp('ends_at')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });

        Schema::table('customers_subscriptions', function ($table) {
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
        Schema::dropIfExists('customers_subscriptions');
    }
}
