<?php namespace App\Models;

use CodeIgniter\Model;

class PrefixeAutreOperateurModel extends Model
{
    protected $table         = 'prefixe_autre_operateur';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom_operateur', 'prefixe'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;
}