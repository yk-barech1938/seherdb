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
        Schema::create('legal_camps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('father');
            $table->string('description')->nullable();
            $table->integer('gender_id');
            $table->string('document_no')->nullable();
            $table->string('contact')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('camp')->nullable();
            $table->string('conducted')->nullable();
            $table->string('issue')->nullable();
            $table->string('remarks')->nullable();
            $table->string('address_pakistan')->nullable();
            $table->string('address_afghanistan')->nullable();
            $table->string('location')->nullable();
            $table->string('nationality')->nullable();
            $table->string('identity_code')->nullable();
            $table->integer('user_id');
            $table->integer('activities_id');
            $table->datetime('session_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_camps');
    }
};
