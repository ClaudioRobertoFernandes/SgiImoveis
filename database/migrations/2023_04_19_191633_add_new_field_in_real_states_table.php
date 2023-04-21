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
        Schema::table('real_states', static function (Blueprint $table) {
            $table->integer('value_base')->default(0)->after('first_release')->comment('Valor base para calculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_states', static function (Blueprint $table) {
            $table->dropColumn('value_base');
        });
    }
};
