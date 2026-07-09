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
        Schema::table('dossiers', function (Blueprint $table) {
            // Ajout de la colonne pour la photo (indispensable pour ton erreur actuelle)
            $table->string('photo_site')->nullable()->after('document_pdf');

            // Ajout des colonnes pour le circuit administratif (pour la suite du mémoire)
            $table->text('avis_geologue')->nullable()->after('photo_site');
            $table->text('avis_chef_division')->nullable()->after('avis_geologue');
            $table->timestamp('date_validation_finale')->nullable()->after('avis_chef_division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            // On retire les colonnes si on annule la migration
            $table->dropColumn(['photo_site', 'avis_geologue', 'avis_chef_division', 'date_validation_finale']);
        });
    }
};