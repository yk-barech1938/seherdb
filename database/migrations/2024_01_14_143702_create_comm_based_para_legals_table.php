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
        Schema::create('comm_based_para_legals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('father');
            $table->integer('gender_id');
            $table->string('document_no')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('camp')->nullable();
            $table->string('conducted')->nullable();
            $table->datetime('session_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comm_based_para_legals');
    }
};
