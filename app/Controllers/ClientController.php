<?php

namespace App\Controllers;

use App\Models\BaremeModel;
use App\Models\OperationModel;
use App\Models\SoldeModel;
use App\Models\TypeOperationModel;
use App\Models\UtilisateurModel;

class ClientController extends BaseController
{
    protected SoldeModel $soldeModel;
    protected OperationModel $operationModel;
    protected TypeOperationModel $typeOperationModel;
    protected BaremeModel $baremeModel;
    protected UtilisateurModel $utilisateurModel;

    public function __construct()
    {
        $this->soldeModel         = new SoldeModel();
        $this->operationModel     = new OperationModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeModel        = new BaremeModel();
        $this->utilisateurModel   = new UtilisateurModel();
    }

    /**
     * Récupère l'id de l'utilisateur connecté depuis la session.
     * (Le filtre 'auth:client' garantit déjà qu'il est connecté et non-opérateur.)
     */
    private function idUtilisateurConnecte(): int
    {
        return (int) session()->get('id_utilisateur');
    }

    /**
     * Tableau de bord : affiche le solde courant.
     */
    public function dashboard()
    {
        $idUtilisateur = $this->idUtilisateurConnecte();
        $solde         = $this->soldeModel->getSoldeUtilisateur($idUtilisateur);

        return view('client/dashboard', [
            'solde'  => $solde['valeur'] ?? 0,
            'numero' => session()->get('numero'),
        ]);
    }

    /**
     * Formulaire + traitement du dépôt.
     * Supposé automatique : aucune validation externe, crédite directement.
     */
    public function depot()
    {
        if ($this->request->getMethod() === 'POST') {
            $montant = (float) $this->request->getPost('montant');

            if ($montant <= 0) {
                return redirect()->back()->with('erreur', 'Montant invalide.');
            }

            $idUtilisateur     = $this->idUtilisateurConnecte();
            $idTypeOperation   = $this->typeOperationModel->getIdParNom('depot');

            // Le dépôt n'a pas de frais dans ce projet (frais = 0)
            $db = \Config\Database::connect();
            $db->transStart();

            $this->soldeModel->crediter($idUtilisateur, $montant);
            $this->operationModel->enregistrer(
                $idTypeOperation,
                null,              // pas d'envoyeur (source externe)
                $idUtilisateur,    // destinataire = soi-même
                $montant,
                0
            );

            $db->transComplete();

            return redirect()->to('/client/dashboard')->with('succes', 'Dépôt effectué avec succès.');
        }

        return view('client/depot');
    }

    /**
     * Formulaire + traitement du retrait.
     * Supposé automatique : vérifie juste que le solde est suffisant.
     */
    public function retrait()
    {
        if ($this->request->getMethod() === 'POST') {
            $montant = (float) $this->request->getPost('montant');

            if ($montant <= 0) {
                return redirect()->back()->with('erreur', 'Montant invalide.');
            }

            $idUtilisateur   = $this->idUtilisateurConnecte();
            $idTypeOperation = $this->typeOperationModel->getIdParNom('retrait');

            try {
                $frais = $this->baremeModel->calculerFrais($idTypeOperation, $montant);
            } catch (\RuntimeException $e) {
                return redirect()->back()->with('erreur', $e->getMessage());
            }

            $solde = $this->soldeModel->getSoldeUtilisateur($idUtilisateur);
            $total = $montant + $frais;

            if (!$solde || $solde['valeur'] < $total) {
                return redirect()->back()->with('erreur', 'Solde insuffisant pour ce retrait (montant + frais).');
            }

            $db = \Config\Database::connect();
            $db->transStart();

            $this->soldeModel->debiter($idUtilisateur, $total);
            $this->operationModel->enregistrer(
                $idTypeOperation,
                $idUtilisateur,
                null,
                $montant,
                $frais
            );

            $db->transComplete();

            return redirect()->to('/client/dashboard')
                ->with('succes', "Retrait effectué. Frais appliqué : {$frais} Ar.");
        }

        return view('client/retrait');
    }

    /**
     * Formulaire + traitement du transfert vers un autre utilisateur.
     */
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

            $idTypeOperation = $this->typeOperationModel->getIdParNom('transfert');

            try {
                $frais = $this->baremeModel->calculerFrais($idTypeOperation, $montant);
            } catch (\RuntimeException $e) {
                return redirect()->back()->with('erreur', $e->getMessage());
            }

            $solde = $this->soldeModel->getSoldeUtilisateur($idUtilisateur);
            $total = $montant + $frais;

            if (!$solde || $solde['valeur'] < $total) {
                return redirect()->back()->with('erreur', 'Solde insuffisant pour ce transfert (montant + frais).');
            }

            $db = \Config\Database::connect();
            $db->transStart();

            $this->soldeModel->debiter($idUtilisateur, $total);
            $this->soldeModel->crediter((int) $destinataire['id'], $montant);

            $this->operationModel->enregistrer(
                $idTypeOperation,
                $idUtilisateur,
                (int) $destinataire['id'],
                $montant,
                $frais
            );

            $db->transComplete();

            return redirect()->to('/client/dashboard')
                ->with('succes', "Transfert effectué. Frais appliqué : {$frais} Ar.");
        }

        return view('client/transfert');
    }

    /**
     * Historique des opérations (envoyées et reçues).
     */
    public function historique()
    {
        $idUtilisateur = $this->idUtilisateurConnecte();
        $operations    = $this->operationModel->getHistoriqueUtilisateur($idUtilisateur);

        return view('client/historique', [
            'operations'    => $operations,
            'idUtilisateur' => $idUtilisateur,
        ]);
    }
}
