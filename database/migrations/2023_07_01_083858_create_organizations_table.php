<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();            
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('auth_code');
            $table->string('timezone')->nullable();
            $table->boolean('lead_reshuffle')->default(0);
            $table->integer('lead_reshuffle_period')->default(1)->constrained('reshuffle_periods');
            $table->string('reporting_email')->nullable();
            $table->boolean('report_via_email')->default(0);
            $table->integer('report_period')->default(1)->constrained('report_periods');
            $table->boolean('is_active')->default(1);
            $table->string('logo')->nullable();
            $table->boolean('fee_waived')->default(0);
            $table->foreignId('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
