<?php
namespace App\Controllers;
use App\Models\ProduitModel;
class Produit extends BaseController
{
public function index()
{
$data = ['a'];
return view('produits', ['data'=>$data] );
}

public function show($id)
{
return "Produit ID : " . $id;
}
}