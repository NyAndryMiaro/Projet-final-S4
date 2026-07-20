<?php

namespace App\Controllers;

use App\Models\BaremeModel;
use App\Models\OperationModel;
use App\Models\TypeOperationModel;
use App\Models\UtilisateurModel;

class ClientController extends BaseController
{
    protected OperationModel $operationModel;
    protected TypeOperationModel $typeOperationModel;
    protected BaremeModel $baremeModel;
    protected UtilisateurModel $utilisateurModel;

    public function __construct()
    {
        $this->operationModel     = new OperationModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeModel        = new BaremeModel();
        $this->utilisateurModel   = new UtilisateurModel();
    }

    private function idUtilisateurConnecte(): int
    {
        return (int) session()->get('id_utilisateur');
    }

    private function idTypeOperationParNom(string $nom): ?int
    {
        $typeOperation = $this->typeOperationModel->getByNom($nom);

        return $typeOperation ? (int) $typeOperation['id'] : null;
    }

    private function debiterSolde(int $idUtilisateur, float $montant): bool
    {
        $solde = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);

        if (!$solde) {
            return false;
        }

        return $this->utilisateurModel->update($idUtilisateur, [
            'solde' => (float) $solde['solde'] - $montant,
        ]);
    }

    public function dashboard()
    {
        $idUtilisateur = $this->idUtilisateurConnecte();
        $solde         = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);

        return view('client/dashboard', [
            'solde'  => $solde ?? 0,
            'numero' => session()->get('numero'),
        ]);
    }

    public function depot()
    {
        if ($this->request->getMethod() === 'POST') {
            $montant = (float) $this->request->getPost('montant');

            if ($montant <= 0) {
                return redirect()->back()->with('erreur', 'Montant invalide.');
            }

            $idUtilisateur     = $this->idUtilisateurConnecte();
            $idTypeOperation   = 1;

            $db = \Config\Database::connect();
            $db->transStart();

            $this->utilisateurModel->crediterSolde($idUtilisateur, $montant);
            $this->operationModel->insert([
                'id_type_operation' => $idTypeOperation,
                'envoyeur'          => null,
                'destinataire'      => $idUtilisateur,
                'valeur'            => $montant,
                'frais'             => 0,
                'date_operation'    => date('Y-m-d H:i:s'),
            ]);

            $db->transComplete();

            return redirect()->to('/dashboard')->with('succes', 'Dépôt effectué avec succès.');
        }

        return view('client/depot');
    }

    public function retrait()
    {
        if ($this->request->getMethod() === 'POST') {
            $montant = (float) $this->request->getPost('montant');

            if ($montant <= 0) {
                return redirect()->back()->with('erreur', 'Montant invalide.');
            }

            $idUtilisateur   = $this->idUtilisateurConnecte();
            $idTypeOperation = $this->idTypeOperationParNom('retrait');

            if (!$idTypeOperation) {
                return redirect()->back()->with('erreur', 'Type d\'opération retrait introuvable.');
            }

            $frais = $this->baremeModel->getFraisPourMontant($montant);

            $solde = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);
            $total = $montant + $frais;

            if (!$solde || $solde['solde'] < $total) {
                return redirect()->back()->with('erreur', 'Solde insuffisant pour ce retrait (montant + frais).');
            }

            $db = \Config\Database::connect();
            $db->transStart();

            $this->debiterSolde($idUtilisateur, $total);
            $this->operationModel->insert([
                'id_type_operation' => $idTypeOperation,
                'envoyeur'          => $idUtilisateur,
                'destinataire'      => null,
                'valeur'            => $montant,
                'frais'             => $frais,
                'date_operation'    => date('Y-m-d H:i:s'),
            ]);

            $db->transComplete();

            return redirect()->to('/client/dashboard')
                ->with('succes', "Retrait effectué. Frais appliqué : {$frais} Ar.");
        }

        return view('client/retrait');
    }

    public function transfert()
    {
        if ($this->request->getMethod() === 'POST') {
            $montant          = (float) $this->request->getPost('montant');
            $numeroDestinataire = trim($this->request->getPost('numero_destinataire'));

            if ($montant <= 0) {
                return redirect()->back()->with('erreur', 'Montant invalide.');
            }

            $idUtilisateur = $this->idUtilisateurConnecte();

            $destinataire = $this->utilisateurModel->findByNumero($numeroDestinataire);

            if (!$destinataire) {
                return redirect()->back()->with('erreur', 'Le numéro destinataire est introuvable.');
            }

            if ((int) $destinataire['id'] === $idUtilisateur) {
                return redirect()->back()->with('erreur', 'Vous ne pouvez pas vous transférer à vous-même.');
            }

            $idTypeOperation = $this->idTypeOperationParNom('transfert');

            if (!$idTypeOperation) {
                return redirect()->back()->with('erreur', 'Type d\'opération transfert introuvable.');
            }

            $frais = $this->baremeModel->getFraisPourMontant($montant);

            $solde = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);
            $total = $montant + $frais;

            if (!$solde || $solde['solde'] < $total) {
                return redirect()->back()->with('erreur', 'Solde insuffisant pour ce transfert (montant + frais).');
            }

            $db = \Config\Database::connect();
            $db->transStart();

            $this->debiterSolde($idUtilisateur, $total);
            $this->utilisateurModel->crediterSolde((int) $destinataire['id'], $montant);

            $this->operationModel->insert([
                'id_type_operation' => $idTypeOperation,
                'envoyeur'          => $idUtilisateur,
                'destinataire'      => (int) $destinataire['id'],
                'valeur'            => $montant,
                'frais'             => $frais,
                'date_operation'    => date('Y-m-d H:i:s'),
            ]);

            $db->transComplete();

            return redirect()->to('/client/dashboard')
                ->with('succes', "Transfert effectué. Frais appliqué : {$frais} Ar.");
        }

        return view('client/transfert');
    }

    public function historique()
    {
        $idUtilisateur = $this->idUtilisateurConnecte();
        $operations    = $this->operationModel->historiqueUtilisateur($idUtilisateur);

        return view('client/historique', [
            'operations'    => $operations,
            'idUtilisateur' => $idUtilisateur,
        ]);
    }
}
