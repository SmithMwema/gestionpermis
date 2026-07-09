<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            // On ajoute toutes les colonnes nécessaires au circuit de la Division
            if (!Schema::hasColumn('dossiers', 'motif_rejet')) {
                $table->text('motif_rejet')->nullable()->after('statut');
            }
            if (!Schema::hasColumn('dossiers', 'message_administration')) {
                $table->text('message_administration')->nullable()->after('motif_rejet');
            }
            if (!Schema::hasColumn('dossiers', 'avis_geologue')) {
                $table->text('avis_geologue')->nullable()->after('message_administration');
            }
            if (!Schema::hasColumn('dossiers', 'avis_chef_division')) {
                $table->text('avis_chef_division')->nullable()->after('avis_geologue');
            }
            if (!Schema::hasColumn('dossiers', 'date_validation_finale')) {
                $table->timestamp('date_validation_finale')->nullable()->after('avis_chef_division');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn([
                'motif_rejet', 
                'message_administration', 
                'avis_geologue', 
                'avis_chef_division', 
                'date_validation_finale'
            ]);
        });
    }
};