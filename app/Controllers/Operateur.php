<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Operateur extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // 1. Page de gestion des préfixes (Nos préfixes + Préfixes autres opérateurs)
    public function prefixes()
    {
        $data['nos_prefixes'] = $this->db->query("SELECT * FROM prefixe_operateur ORDER BY prefixe ASC")->getResultArray();
        $data['autres_prefixes'] = $this->db->query("SELECT * FROM prefixe_autre_operateur ORDER BY nom_operateur ASC")->getResultArray();

        return view('operateur/prefixes', $data);
    }

    // Ajouter un préfixe pour notre opérateur
    public function ajouterMonPrefixe()
    {
        $prefixe = trim($this->request->getPost('prefixe'));
        if (!empty($prefixe)) {
            $this->db->query("INSERT OR IGNORE INTO prefixe_operateur (prefixe) VALUES (?)", [$prefixe]);
        }
        return redirect()->to('/operateur/prefixes')->with('success', 'Mon préfixe ajouté.');
    }

    // Ajouter un préfixe pour un autre opérateur
    public function ajouterAutrePrefixe()
    {
        $nom = trim($this->request->getPost('nom_operateur'));
        $prefixe = trim($this->request->getPost('prefixe'));

        if (!empty($nom) && !empty($prefixe)) {
            $this->db->query("INSERT OR IGNORE INTO prefixe_autre_operateur (nom_operateur, prefixe) VALUES (?, ?)", [$nom, $prefixe]);
        }
        return redirect()->to('/operateur/prefixes')->with('success', 'Autre opérateur ajouté.');
    }

    // 2. Mettre à jour le % de commission inter-opérateur
    public function configCommission()
    {
        $pourcentage = (float) $this->request->getPost('pourcentage');

        // Récupérer le premier enregistrement s'il existe, sinon créer
        $check = $this->db->query("SELECT id FROM config_commission_inter_operateur LIMIT 1")->getRow();
        if ($check) {
            $this->db->query("UPDATE config_commission_inter_operateur SET pourcentage = ? WHERE id = ?", [$pourcentage, $check->id]);
        } else {
            $this->db->query("INSERT INTO config_commission_inter_operateur (pourcentage) VALUES (?)", [$pourcentage]);
        }

        return redirect()->to('/operateur/rapports')->with('success', 'Pourcentage de commission mis à jour.');
    }

    // 3. Rapports Financiers Opérateur
    public function rapports()
    {
        // Récupérer la commission actuelle configurée
        $config = $this->db->query("SELECT pourcentage FROM config_commission_inter_operateur ORDER BY id DESC LIMIT 1")->getRow();
        $data['commission_pct'] = $config ? (float)$config->pourcentage : 0.0;

        // A. Gains opérations internes (Sans autre opérateur)
        $data['gains_internes'] = $this->db->query("
            SELECT 
                t.nom AS type_operation,
                COUNT(o.id) AS nb_operations,
                SUM(o.frais) AS total_frais
            FROM operation o
            JOIN type_operation t ON o.id_type_operation = t.id
            WHERE o.id_autre_operateur IS NULL
            GROUP BY t.nom
        ")->getResultArray();

        // B. Gains opérations inter-opérateurs (Transferts sortants)
        $data['gains_externe'] = $this->db->query("
            SELECT 
                p.nom_operateur,
                COUNT(o.id) AS nb_operations,
                SUM(o.valeur) AS total_brut,
                SUM(o.frais) AS total_frais_base,
                SUM(o.valeur * (? / 100.0)) AS total_commission_percue
            FROM operation o
            JOIN prefixe_autre_operateur p ON o.id_autre_operateur = p.id
            GROUP BY p.nom_operateur
        ", [$data['commission_pct']])->getResultArray();

        // C. Situation des montants nets à reverser par opérateur concurrent
        $data['montants_a_reverser'] = $this->db->query("
            SELECT 
                p.nom_operateur,
                p.prefixe,
                COUNT(o.id) AS total_transferts,
                SUM(o.valeur) AS total_envoye,
                SUM(o.valeur * (? / 100.0)) AS commission_deduite,
                SUM(o.valeur - (o.valeur * (? / 100.0))) AS net_a_reverser
            FROM operation o
            JOIN prefixe_autre_operateur p ON o.id_autre_operateur = p.id
            GROUP BY p.id
        ", [$data['commission_pct'], $data['commission_pct']])->getResultArray();

        return view('operateur/rapports', $data);
    }
}