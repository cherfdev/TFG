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
        Schema::create('cour_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cour_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'ID de l'étudiant
            $table->timestamps();
            $table->unique(['cour_id', 'user_id']); // Un étudiant ne peut s'inscrire qu'une fois à un cours
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cour_user');
    }
};
