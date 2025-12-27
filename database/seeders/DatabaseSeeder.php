<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ResearchTeam;
use App\Models\Category;
use App\Models\Publication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un administrateur
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@lab.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'specialite' => 'Administration'
        ]);

        // 2. Créer des catégories
        $categories = [
            ['nom' => 'Informatique', 'description' => 'Sciences informatiques et technologies'],
            ['nom' => 'Biologie', 'description' => 'Sciences biologiques et médicales'],
            ['nom' => 'Physique', 'description' => 'Physique fondamentale et appliquée'],
            ['nom' => 'Mathématiques', 'description' => 'Mathématiques pures et appliquées'],
            ['nom' => 'Chimie', 'description' => 'Sciences chimiques'],
            ['nom' => 'Ingénierie', 'description' => 'Génie civil, mécanique, électrique'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 3. Créer des équipes de recherche
        $team1 = ResearchTeam::create([
            'name' => 'Équipe Intelligence Artificielle',
            'description' => 'Recherche en intelligence artificielle, machine learning et deep learning',
            'domaine' => 'Informatique',
            'team_leader_id' => $admin->id,
        ]);

        $team2 = ResearchTeam::create([
            'name' => 'Équipe Biologie Moléculaire',
            'description' => 'Recherche en biologie moléculaire et génétique',
            'domaine' => 'Biologie',
            'team_leader_id' => $admin->id,
        ]);

        $team3 = ResearchTeam::create([
            'name' => 'Équipe Physique Quantique',
            'description' => 'Recherche en physique quantique et nanotechnologies',
            'domaine' => 'Physique',
            'team_leader_id' => $admin->id,
        ]);

        // 4. Créer des chercheurs
        $specialites = ['IA', 'Biologie', 'Physique', 'Maths', 'Chimie', 'Robotique'];
        $domaines = ['Informatique', 'Biologie', 'Physique', 'Mathématiques', 'Chimie', 'Ingénierie'];

        for ($i = 1; $i <= 10; $i++) {
            // Choisir une équipe aléatoire
            $teamId = rand(1, 3);
            $team = ResearchTeam::find($teamId);
            
            $chercheur = User::create([
                'name' => 'Chercheur ' . $i,
                'email' => 'chercheur' . $i . '@lab.com',
                'password' => Hash::make('password'),
                'role' => 'chercheur',
                'specialite' => $specialites[array_rand($specialites)],
                'research_team_id' => $teamId,
            ]);

            // Créer 2-4 publications pour chaque chercheur
            $nbPublications = rand(2, 4);
            for ($j = 1; $j <= $nbPublications; $j++) {
                $type = ['article', 'conference', 'chapitre'][rand(0, 2)];
                $annee = rand(2018, 2024);
                $categoryId = rand(1, 6);

                Publication::create([
                    'titre' => 'Étude sur ' . ['l\'IA', 'la biologie', 'la physique', 'les maths'][rand(0, 3)] . ' - Publication ' . $j,
                    'resume' => 'Cette publication présente une étude approfondie sur un sujet important dans le domaine. Les résultats montrent des avancées significatives qui pourraient avoir un impact majeur.',
                    'annee' => $annee,
                    'type' => $type,
                    'user_id' => $chercheur->id,
                    'research_team_id' => $teamId,
                    'category_id' => $categoryId,
                    'journal' => ['Nature', 'Science', 'IEEE', 'Springer', 'Elsevier'][rand(0, 4)] . ' ' . $type,
                    'fichier_pdf' => 'https://example.com/publication' . $i . '_' . $j . '.pdf',
                ]);
            }

            // Mettre à jour le chef d'équipe pour la première équipe
            if ($i == 1) {
                $team1->update(['team_leader_id' => $chercheur->id]);
            }
        }

        // 5. Afficher un message
        $this->command->info('✅ Base de données peuplée avec succès!');
        $this->command->info('👑 Admin: admin@lab.com / admin123');
        $this->command->info('👨‍🔬 Chercheurs: chercheur1@lab.com / password');
    }
}