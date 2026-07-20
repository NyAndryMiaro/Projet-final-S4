<?php

namespace App\Controllers;

use App\Models\PrefixeOperateurModel;
use App\Models\UtilisateurModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('auth/login');
    }

    public function login() {
        $utilisateurModel = new UtilisateurModel();
        $prefixeModel = new PrefixeOperateurModel();

        $numero = $this->request->getPost('numero');

        // if (!$prefixeModel->numeroEstValide($numero)) {
        //     return redirect()->back()->with('erreur', 'Le numéro de téléphone n\'est pas valide.');
        // }

        $utilisateur = $utilisateurModel->findByNumero($numero);

        if (!$utilisateur) {
            $utilisateurId = $utilisateurModel->creerClient($numero);
            $utilisateur = $utilisateurModel->find($utilisateurId);
        }

        session()->set('id_utilisateur', $utilisateur['id']);

        return redirect()->to('dashboard');
    }
}
