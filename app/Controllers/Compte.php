<?php

namespace App\Controllers;

use App\Models\OperationModel;
use App\Models\UtilisateurModel;
use Throwable;

class Compte extends BaseController
{
    public function index(): string
    {
        $numero = $this->request->getGet('numero');
        $utilisateur = null;
        $historique = [];
        $error = null;

        try {
            if ($numero) {
                $utilisateur = (new UtilisateurModel())->findByNumero($numero);

                if ($utilisateur) {
                    $historique = (new OperationModel())->historiqueUtilisateur((int) $utilisateur['id']);
                }
            }
        } catch (Throwable $exception) {
            $error = 'Impossible de charger le compte pour le moment.';
            log_message('error', 'Compte index DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('client/compte', [
            'numero' => $numero,
            'utilisateur' => $utilisateur,
            'historique' => $historique,
            'error' => $error,
        ]);
    }

    public function depot(): string
    {
        return view('client/depot');
    }

    public function retrait(): string
    {
        return view('client/retrait');
    }

    public function transfert(): string
    {
        return view('client/transfert');
    }

    public function historique(): string
    {
        return view('client/historique');
    }
}