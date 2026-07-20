<?php namespace App\Controllers\Operateur;
use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class Comptes extends BaseController
{
    public function index()
    {
        $numero = $this->request->getGet('numero');
        return view('operateur/comptes/index', [
            'utilisateurs' => (new UtilisateurModel())->rechercheParNumero($numero),
            'numero' => $numero,
        ]);
    }
}