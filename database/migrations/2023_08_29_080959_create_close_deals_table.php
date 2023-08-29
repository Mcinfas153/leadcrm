<?php

use App\Models\Lead;
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
        Schema::create('close_deals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lead::class);
            $table->integer('total_value');
            $table->integer('total_commision');
            $table->json('commision_details')->nullable();
            $table->integer('business_id')->constrained('organizations');
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
        Schema::dropIfExists('close_deals');
    }
};
