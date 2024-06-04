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
        Schema::table('proj_participants', function (Blueprint $table) {
            $table->date('joined_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proj_participants', function (Blueprint $table) {
            $table->dropColumn('joined_date');
            $table->dropColumn('end_date');
        });
    }
};
