<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\CLI\CLI;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $sqlFile = ROOTPATH . 'base.sql';

        if (!file_exists($sqlFile)) {
            CLI::error("Erreur : Le fichier base.sql est introuvable à la racine.");
            return;
        }

        $sql = file_get_contents($sqlFile);

        try {
            // Récupère l'instance brute de SQLite3 pour exécuter tout le script d'un coup
            $dbPath = WRITEPATH . 'database.sqlite';
            $sqlite = new \SQLite3($dbPath);
            
            if ($sqlite->exec($sql)) {
                CLI::write("Base de données initialisée avec succès dans writable/database.sqlite !", "green");
            } else {
                CLI::error("Erreur lors de l'exécution du script SQL.");
            }
            
            $sqlite->close();
        } catch (\Throwable $e) {
            CLI::error("Erreur : " . $e->getMessage());
        }
    }
}