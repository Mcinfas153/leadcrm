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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email');
            $table->string('whatsapp')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('budget')->nullable();
            $table->string('contact_time')->nullable();
            $table->string('purpose')->nullable();
            $table->text('inquiry')->nullable();
            $table->string('campaign_name')->nullable();
            $table->string('property_type')->nullable();
            $table->string('bedroom')->nullable();
            $table->foreignId('status')->default(1);
            $table->string('source')->nullable();
            $table->foreignId('priority')->default(1);
            $table->string('developer')->nullable();
            $table->foreignId('type')->default(1);
            $table->string('attachment')->nullable();
            $table->foreignId('assign_to')->nullable();
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
        Schema::dropIfExists('leads');
    }
};
