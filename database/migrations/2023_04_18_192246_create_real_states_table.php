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
        Schema::create('real_states', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Id de identificação da imobiliaria')->constrained('users');
            $table->foreignId('real_estate_belongs')->comment('Id de identificação do usuario ao qual aimobiliaria esta vinculado')->constrained('users');
            $table->integer('first_release')->default(1);
            $table->integer('recurrent_release')->default(1);
            $table->integer('entrance_fees')->default(1)->comment('Taxa de entrada');
            $table->integer('exit_fees')->default(1)->comment('Taxa de saída');
            $table->integer('daily_interest')->default(1)->comment('Juros diario');
            $table->integer('monthly_interest')->default(1)->comment('Juros mensal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_states');
    }
};