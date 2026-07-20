<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UtilisateurModel;
use Throwable;

class Comptes extends BaseController
{
    public function index()
    {
        $numero = $this->request->getGet('numero');
        $utilisateurs = [];
        $error = null;

        try {
            $utilisateurs = (new UtilisateurModel())->rechercheParNumero($numero);
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les comptes clients pour le moment.';
            log_message('error', 'Comptes DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/comptes/index', [
            'utilisateurs' => $utilisateurs,
            'numero' => $numero,
            'error' => $error,
        ]);
    }
}