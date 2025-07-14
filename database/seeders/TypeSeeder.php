<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        Type::firstOrCreate(['nom' => 'texte libre']);
        Type::firstOrCreate(['nom' => 'qcm']); // Choix multiples
        Type::firstOrCreate(['nom' => 'cases à cocher']); // Choix multiples, plusieurs réponses
        Type::firstOrCreate(['nom' => 'échelle de likert']); // (1 à 5, pas d'accord -> tout à fait d'accord)
        Type::firstOrCreate(['nom' => 'notation par étoiles']); // (1 à 5 étoiles)
    }
}
