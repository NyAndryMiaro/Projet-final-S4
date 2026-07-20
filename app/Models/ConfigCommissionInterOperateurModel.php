<?php namespace App\Models;

use CodeIgniter\Model;

class ConfigCommissionInterOperateurModel extends Model
{
    protected $table         = 'config_commission_inter_operateur';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['pourcentage'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;
}