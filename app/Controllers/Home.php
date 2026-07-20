<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;
use App\Models\PrefixeOperateurModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('/auth/login');
    }

    public function login() {
        $numero = $this->request->getPost('numero');

        $utilisateurModel = new UtilisateurModel();
        $prefixeModel = new PrefixeOperateurModel();

        // if (!$prefixeModel->numeroEstValide($numero)) {
        //     return redirect()->back()->with('erreur', 'Le numéro de téléphone n\'est pas valide.');
        // }

        // $utilisateur = $utilisateurModel->findByNumero($numero);

        // if (!$utilisateur) {
        //     $utilisateurId = $utilisateurModel->creerClient($numero);
        //     $utilisateur = $utilisateurModel->find($utilisateurId);
        // }

        // session()->set('utilisateur', $utilisateur);

        return view('/client/dashboard');
    }
}
