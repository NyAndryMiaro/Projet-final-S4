<?php
namespace App\Controllers;
use App\Models\ProduitModel;
class Etudiant extends BaseController
{
    
public function liste()
{
$liste = [['nom'=>'Etudiant 1','numero'=>'1'], ['nom'=>'Etudiant 2','numero'=>'2']];
return view('liste_etudiant', ['liste'=>$liste] );
}

}