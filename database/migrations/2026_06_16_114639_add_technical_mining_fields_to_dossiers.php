<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ajoute les champs techniques requis pour l'expertise de la Division des Mines.
     */
public function up(): void
{
    Schema::table('dossiers', function (Blueprint $table) {
        $table->string('territoire')->nullable()->after('nom_site');
        $table->string('substance')->nullable()->after('territoire');
        $table->integer('nombre_carres')->default(0)->after('substance');
        $table->json('coordonnees_gps')->nullable()->after('nombre_carres');
        $table->boolean('conflit_detecte')->default(false)->after('coordonnees_gps');
        
        // NOUVEAU : Le chemin vers l'Avis de Conformité généré
        $table->string('avis_technique_pdf')->nullable()->after('document_pdf');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn([
                'territoire', 
                'substance', 
                'nombre_carres', 
                'coordonnees_gps', 
                'conflit_detecte'
            ]);
        });
    }
};