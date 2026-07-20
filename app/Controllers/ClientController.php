<?php

namespace App\Controllers;

use App\Models\BaremeModel;
use App\Models\OperationModel;
use App\Models\TypeOperationModel;
use App\Models\UtilisateurModel;
use App\Models\PrefixeOperateurModel;

class ClientController extends BaseController
{
    protected OperationModel $operationModel;
    protected TypeOperationModel $typeOperationModel;
    protected BaremeModel $baremeModel;
    protected UtilisateurModel $utilisateurModel;
    protected PrefixeOperateurModel $prefixeModel;

    public function __construct()
    {
        $this->operationModel     = new OperationModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeModel        = new BaremeModel();
        $this->utilisateurModel   = new UtilisateurModel();
        $this->prefixeModel       = new PrefixeOperateurModel();
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
            'solde' => (float) $solde - $montant,
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

            if (!$solde || $solde < $total) {
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

            return redirect()->to('/dashboard')
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

            $frais = $this->baremeModel->calculerFrais(3 ,$montant);

            if($this->prefixeModel->verifierDeuxPrefixes(session()->get('numero'), $numeroDestinataire) == false) {
                $tab = $this->utilisateurModel->getCommission();
                $pourcentage = $tab;
                if($pourcentage < 1) $pourcentage = 1;
                $commission = $frais * ($pourcentage / 100);
                $frais += $commission;
            }

            $solde = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);
            $total = $montant + $frais;

            if (!$solde || $solde < $total) {
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

            return redirect()->to('/dashboard')
                ->with('succes', "Transfert effectué. Frais appliqué : {$frais} Ar.");
        }

        return view('client/transfert');
    }

    public function transfertMultiple()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/transfert');
        }

        $montantTotal = (float) $this->request->getPost('montant_total');
        $numerosBrut  = $this->request->getPost('numeros') ?? [];

        $numeros = array_values(array_filter(array_map('trim', $numerosBrut), static fn ($n) => $n !== ''));

        if ($montantTotal <= 0) {
            return redirect()->back()->withInput()->with('erreur', 'Montant total invalide.');
        }

        if (count($numeros) < 2) {
            return redirect()->back()->withInput()->with('erreur', 'Veuillez saisir au moins 2 numéros pour un envoi multiple.');
        }

        if (count($numeros) !== count(array_unique($numeros))) {
            return redirect()->back()->withInput()->with('erreur', 'Un même numéro a été saisi plusieurs fois.');
        }

        $idUtilisateur  = $this->idUtilisateurConnecte();
        $numeroEnvoyeur = session()->get('numero');

        $nbDestinataires = count($numeros);

        $montantParDestinataire = floor($montantTotal / $nbDestinataires);

        if ($montantParDestinataire <= 0) {
            return redirect()->back()->withInput()->with('erreur', 'Le montant total est trop faible pour être réparti entre tous les destinataires.');
        }

        $idTypeOperation = $this->idTypeOperationParNom('transfert');

        if (!$idTypeOperation) {
            return redirect()->back()->with('erreur', "Type d'opération transfert introuvable.");
        }

        $destinataires = [];

        foreach ($numeros as $numero) {
            if ($numero === $numeroEnvoyeur) {
                return redirect()->back()->withInput()->with('erreur', "Vous ne pouvez pas vous inclure vous-même ({$numero}) dans la liste des destinataires.");
            }

            if (!$this->prefixeModel->verifierDeuxPrefixes($numeroEnvoyeur, $numero)) {
                return redirect()->back()->withInput()->with('erreur', "Vous essayez de faire un multi transfert avec un autre opérateur."+
                " ({$numero}). Cette opération n'est pas autorisée.");
            }

            $utilisateur = $this->utilisateurModel->findByNumero($numero);

            if (!$utilisateur) {
                return redirect()->back()->withInput()->with('erreur', "Le numéro {$numero} est introuvable.");
            }

            $destinataires[] = $utilisateur;
        }

        $fraisParDestinataire = $this->baremeModel->getFraisPourMontant($montantParDestinataire);
        $coutParDestinataire  = $montantParDestinataire + $fraisParDestinataire;
        $coutTotal            = $coutParDestinataire * $nbDestinataires;

        $solde = $this->utilisateurModel->getSoldeUtilisateur($idUtilisateur);

        if (!$solde || $solde < $coutTotal) {
            return redirect()->back()->withInput()->with(
                'erreur',
                "Solde insuffisant. Total requis : {$coutTotal} Ar (dont " . ($fraisParDestinataire * $nbDestinataires) . " Ar de frais)."
            );
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->debiterSolde($idUtilisateur, $coutTotal);

        foreach ($destinataires as $destinataire) {
            $this->utilisateurModel->crediterSolde((int) $destinataire['id'], $montantParDestinataire);

            $this->operationModel->insert([
                'id_type_operation' => $idTypeOperation,
                'envoyeur'          => $idUtilisateur,
                'destinataire'      => (int) $destinataire['id'],
                'valeur'            => $montantParDestinataire,
                'frais'             => $fraisParDestinataire,
                'date_operation'    => date('Y-m-d H:i:s'),
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('erreur', "Une erreur est survenue pendant l'envoi multiple. Aucun montant n'a été débité.");
        }

        return redirect()->to('/dashboard')->with(
            'succes',
            "Envoi multiple effectué : {$montantParDestinataire} Ar envoyés à chacun des {$nbDestinataires} destinataires (frais total : " . ($fraisParDestinataire * $nbDestinataires) . " Ar)."
        );
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