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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('district_id');
            $table->integer('user_id');
            $table->date('date');
            $table->string('document_path')->nullable();
             // Create a generated column for movs_name_json
            $table->json('movs_name_json')->virtualAs('JSON_UNQUOTE(JSON_EXTRACT(movs_name, "$[*]"))')->stored();
            // Create indexes for district_id and movs_name_json
            $table->index(['district_id', 'movs_name_json'], 'idx_activities_district_movs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
