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
        Schema::create('awareness_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('father');
            $table->integer('gender_id');
            $table->string('contact')->nullable();
            $table->string('document_no')->nullable();
            $table->datetime('session_date')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('camp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awareness_sessions');
    }
};
