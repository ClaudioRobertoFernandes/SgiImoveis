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
        Schema::table('users', static function (Blueprint $table) {
            $table->string('document')->after('name');
            $table->string('phone')->after('email');
            $table->string('zipCode')->after('remember_token');
            $table->string('state')->after('zipCode');
            $table->string('city')->after('state');
            $table->string('neighborhood')->after('city');
            $table->string('street')->after('neighborhood');
            $table->string('number')->after('street')->default('S/N');
            $table->string('complement')->after('number')->default('S/C');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('zipCode');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('neighborhood');
            $table->dropColumn('street');
            $table->dropColumn('number');
            $table->dropColumn('complement');
        });
    }
};
