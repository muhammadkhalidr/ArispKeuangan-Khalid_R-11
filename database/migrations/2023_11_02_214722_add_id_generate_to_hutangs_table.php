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
        Schema::table('hutangs', function (Blueprint $table) {
            $table->string('id_generate')->nullable()->after('id_hutang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hutangs', function (Blueprint $table) {
            $table->dropColumn('id_generate');
        });
    }
};
