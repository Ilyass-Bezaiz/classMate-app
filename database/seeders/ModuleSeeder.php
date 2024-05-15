<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Génie Logiciel' => ['Programmation Fondamentale', 'Structure de Données et Algorithmes', 'Conception de Logiciels'],
            'Intelligence Artificielle' => ['Apprentissage Automatique', 'Traitement du Langage Naturel'],
            'Physique' => ['Mécanique', 'Électromagnétisme'],
            'Chimie' => ['Chimie Organique', 'Chimie Inorganique'],
            'Comptabilité' => ['Comptabilité Financière', 'Comptabilité de Gestion'],
            'Marketing' => ['Comportement du Consommateur', 'Marketing Numérique'],
            'Littérature' => ['Littérature Française', 'Littérature Comparée'],
            'Linguistique' => ['Grammaire', 'Sémantique'],
            'Droit Public' => ['Droit Constitutionnel', 'Droit Administratif'],
            'Droit Privé' => ['Droit Civil', 'Droit Commercial'],
            // Add more modules for other majors as needed
        ];

        foreach ($modules as $majorName => $moduleNames) {
            $major = Major::where('name', $majorName)->first();

            foreach ($moduleNames as $moduleName) {
                Module::create([
                    'major_id' => $major->id,
                    'name' => $moduleName,
                ]);
            }
        }
    }
}
