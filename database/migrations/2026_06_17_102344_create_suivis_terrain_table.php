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
    // 1. On ajoute les infos d'installation au dossier
    Schema::table('dossiers', function (Blueprint $table) {
        $table->date('date_installation')->nullable()->after('date_validation_finale');
        $table->enum('etat_activite', ['en_attente', 'actif', 'inactif', 'alerte'])->default('en_attente')->after('date_installation');
        $table->timestamp('dernier_rapport_at')->nullable();
    });

    // 2. On crée la table des rapports périodiques
    Schema::create('rapports_activite', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id'); // L'agent territorial qui écrit
        $table->text('contenu');
        $table->enum('constat', ['favorable', 'alerte_inactivite', 'infraction']);
        $table->timestamps();
    });
}
};
