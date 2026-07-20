<?php
namespace App\Controllers;
use App\Models\UtilisateurModel;
use App\Models\PrefixeOperateurModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }
}
