<?php namespace App\Models;
use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table = 'bareme';
    protected $primaryKey = 'id';
    protected $allowedFields = ['born_inf', 'born_sup', 'valeur'];
    protected $returnType = 'array';

    public function getFraisPourMontant(float $montant): float
    {
        $row = $this->where('born_inf <=', $montant)
                    ->where('born_sup >=', $montant)
                    ->first();
        return $row ? (float) $row['valeur'] : 0.0;
    }
}