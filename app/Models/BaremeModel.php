<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table            = 'bareme';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_type_operation',
        'borne_inf',
        'borne_sup',
        'frais',
    ];

    protected $useTimestamps = false;

    /**
     * Calcule le frais applicable pour un montant donné, selon le type
     * d'opération (dépôt = 0 normalement, retrait/transfert = tranches).
     *
     * @throws \RuntimeException si aucune tranche ne correspond au montant
     */
    public function calculerFrais(int $idTypeOperation, float $montant): float
    {
        $tranche = $this->where('id_type_operation', $idTypeOperation)
            ->where('borne_inf <=', $montant)
            ->where('borne_sup >=', $montant)
            ->first();

        if (!$tranche) {
            throw new \RuntimeException("Aucun barème trouvé pour ce montant.");
        }

        return (float) $tranche['valeur'];
    }

    public function getFraisPourMontant(float $montant): float
    {
        $row = $this->where('born_inf <=', $montant)
                    ->where('born_sup >=', $montant)
                    ->first();
        return $row ? (float) $row['valeur'] : 0.0;
    }
}
