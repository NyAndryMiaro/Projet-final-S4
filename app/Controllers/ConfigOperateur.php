<?php

namespace App\Controllers;

use Throwable;

class ConfigOperateur extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $pourcentage = 0.0;
        $autresPrefixes = [];
        $error = null;

        try {
            $configQuery = $db->query("SELECT pourcentage FROM config_commission_inter_operateur ORDER BY id DESC LIMIT 1")->getRow();
            if ($configQuery) {
                $pourcentage = (float) $configQuery->pourcentage;
            }

            $autresPrefixes = $db->query("SELECT * FROM prefixe_autre_operateur ORDER BY nom_operateur ASC, prefixe ASC")->getResultArray();

        } catch (Throwable $e) {
            $error = "Erreur lors du chargement de la configuration : " . $e->getMessage();
            log_message('error', 'ConfigOperateur index error: {message}', ['message' => $e->getMessage()]);
        }

        return view('operateur/config', [
            'pourcentage'     => $pourcentage,
            'autres_prefixes' => $autresPrefixes,
            'error'           => $error
        ]);
    }

    public function saveCommission()
    {
        $pourcentage = $this->request->getPost('pourcentage');

        if (!is_numeric($pourcentage) || $pourcentage < 0) {
            return redirect()->back()->with('error', 'Veuillez saisir un pourcentage valide.');
        }

        try {
            $db = \Config\Database::connect();
            $db->query("INSERT INTO config_commission_inter_operateur (pourcentage) VALUES (?)", [(float)$pourcentage]);

            return redirect()->to('/operateur/config')->with('message', 'Taux de commission mis à jour avec succès.');
        } catch (Throwable $e) {
            log_message('error', 'Save commission error: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Impossible d’enregistrer le pourcentage.');
        }
    }

    public function addPrefixeAutre()
    {
        $nomOperateur = trim((string) $this->request->getPost('nom_operateur'));
        $prefixe = trim((string) $this->request->getPost('prefixe'));

        if (empty($nomOperateur) || empty($prefixe)) {
            return redirect()->back()->with('error', 'Le nom de l\'opérateur et le préfixe sont obligatoires.');
        }

        try {
            $db = \Config\Database::connect();
            $db->query("INSERT INTO prefixe_autre_operateur (nom_operateur, prefixe) VALUES (?, ?)", [$nomOperateur, $prefixe]);

            return redirect()->to('/operateur/config')->with('message', 'Préfixe opérateur tiers ajouté.');
        } catch (Throwable $e) {
            log_message('error', 'Add prefixe autre error: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Ce préfixe existe déjà ou une erreur s\'est produite.');
        }
    }

    public function deletePrefixeAutre($id)
    {
        try {
            $db = \Config\Database::connect();
            $db->query("DELETE FROM prefixe_autre_operateur WHERE id = ?", [$id]);

            return redirect()->to('/operateur/config')->with('message', 'Préfixe supprimé.');
        } catch (Throwable $e) {
            log_message('error', 'Delete prefixe autre error: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Impossible de supprimer ce préfixe.');
        }
    }
}