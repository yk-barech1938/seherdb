<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('helpline_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('call_datetime');
            $table->string('caller_name');
            $table->string('father');
            $table->tinyInteger('gender')->default(0); // 0 for male, 1 for female
            $table->integer('family_size');
            $table->tinyInteger('card_holder')->default(0); // 0 for no card, 1 for card present
            $table->text('pre_address')->nullable();
            $table->text('address_coo')->nullable();
            $table->dateTime('arrival_date');
            $table->string('contact');
            $table->string('issue');
            $table->string('response_alac')->nullable();
            $table->string('respondent')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('activities_id');
            $table->integer('codes_identity')->nullable();
            $table->string('remarks')->nullable();
            $table->string('text1')->nullable();
            $table->string('text2')->nullable();
            $table->string('text3')->nullable();
            $table->string('text4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpline_calls');
    }
};
