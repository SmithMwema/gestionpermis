<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            // Ajout de la colonne pour stocker le chemin de l'Avis de Conformité
            if (!Schema::hasColumn('dossiers', 'avis_technique_pdf')) {
                $table->string('avis_technique_pdf')->nullable()->after('document_pdf');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn('avis_technique_pdf');
        });
    }
};