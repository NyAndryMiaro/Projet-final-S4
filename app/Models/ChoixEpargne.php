<?php

namespace App\Models;

use CodeIgniter\Model;

class ChoixEpargne extends Model
{
    protected $table            = 'epargne';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_utilisateur',
        'pourcentage',
    ];

    protected $useTimestamps = false;

    /**
     * Calcule le frais applicable pour un montant donné, selon le type
     * d'opération (dépôt = 0 normalement, retrait/transfert = tranches).
     *
     * @throws \RuntimeException si aucune tranche ne correspond au montant
     */
    
    public function getPourcentage(int $idUtilisateur){
        $pourcentage = $this->where('id', $idUtilisateur)->first();
        return (float) $pourcentage;
    }
    public function saveOrUpdate(int $idUtilisateur, float $pourcentage){
        // $exist = $this->sa
    }
}