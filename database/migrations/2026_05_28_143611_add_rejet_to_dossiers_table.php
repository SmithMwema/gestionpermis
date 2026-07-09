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
            // Ajout des colonnes pour le traitement du Secrétaire
            $table->text('motif_rejet')->nullable()->after('statut'); 
            $table->text('message_administration')->nullable()->after('motif_rejet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn(['motif_rejet', 'message_administration']);
        });
    }
};