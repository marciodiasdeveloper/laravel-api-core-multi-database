<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants_modules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('tenant_id')->unsigned()->index();
            $table->bigInteger('module_id')->unsigned()->index();
            $table->timestamp('main');
            $table->integer('free')->default(0);
            $table->integer('trial')->default(0);
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });

        Schema::table('tenants_modules', function ($table) {
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants_modules');
    }
}
