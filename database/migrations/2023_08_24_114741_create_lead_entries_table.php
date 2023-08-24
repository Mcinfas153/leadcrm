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
        Schema::create('lead_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('lead_id')->constrained('leads');
            $table->integer('user_id')->constrained('users');
            $table->string('type');
            $table->dateTime('entry_time');
            $table->text('note');
            $table->enum('response', ['positive', 'negative', 'neutral']);
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
        Schema::dropIfExists('lead_entries');
    }
};
