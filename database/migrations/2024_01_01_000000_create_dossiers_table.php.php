<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('numero_demande')->unique(); // Ex: DM/HL/2024/001
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Le titulaire
            $table->string('type_permis'); // PR, PE, PER, PEPM
            $table->string('nom_site'); // Nom du carré minier
            $table->string('statut')->default('en_attente'); // en_attente, instruit, valide, rejete
            $table->text('coordonnees_geo')->nullable(); // Points GPS
            $table->string('document_pdf')->nullable(); // Preuve de paiement
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};