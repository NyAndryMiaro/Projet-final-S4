<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/client/login')->with('erreur', 'Veuillez vous connecter.');
        }

        if ($arguments) {
            $roleAttendu   = $arguments[0]; 
            $estOperateur  = (bool) $session->get('est_operateur');

            if ($roleAttendu === 'operateur' && !$estOperateur) {
                return redirect()->to('/client/dashboard')->with('erreur', 'Accès refusé.');
            }

            if ($roleAttendu === 'client' && $estOperateur) {
                return redirect()->to('/operateur/dashboard')->with('erreur', 'Accès refusé.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après la requête
    }
}
