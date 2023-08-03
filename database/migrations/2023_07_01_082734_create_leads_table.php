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
            $table->integer('status')->default(1)->constrained('lead_statuses');
            $table->string('source')->nullable();
            $table->integer('priority')->default(1)->constrained('priorities');
            $table->string('developer')->nullable();
            $table->integer('type')->default(1)->constrained('lead_types');
            $table->string('attachment')->nullable();
            $table->integer('assign_to')->nullable()->constrained('users');
            $table->integer('created_by')->constrained('users');
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
