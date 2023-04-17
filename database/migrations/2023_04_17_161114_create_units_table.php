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
        Schema::create('units', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->comment('Owner of the unit')->nullable()->constrained('users');
            $table->foreignId('tenant_id')->comment('Tenant of the unit')->nullable()->constrained('users');
            $table->foreignId('building_id')->comment('Building of the unit')->nullable()->constrained('users');
            $table->string('name')->comment('Name of the unit');
            $table->string('block')->nullable()->comment('Block of the unit');
            $table->string('description')->nullable()->comment('Description of the unit');
            $table->string('zip_code')->comment('Zip code of the unit');
            $table->string('state')->comment('State of the unit');
            $table->string('city')->comment('City of the unit');
            $table->string('neighborhood')->comment('Neighborhood of the unit');
            $table->string('street')->comment('Street of the unit');
            $table->string('number')->comment('Number of the unit');
            $table->string('complement')->nullable()->comment('Complement of the unit');
            $table->boolean('active')->default(true)->comment('Unit is active?');
            $table->boolean('empty')->default(true)->comment('Unit is empty?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
