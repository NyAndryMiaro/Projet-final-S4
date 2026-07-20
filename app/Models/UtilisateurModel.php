<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table            = 'utilisateur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $solde = 0;

    protected $allowedFields = [
        'numero_telephone',
        'est_operateur',
        'date_creation',
        'solde',
    ];

    protected $useTimestamps = false;
    public function findByNumero(string $numero): ?array
    {
        return $this->where('numero_telephone', $numero)->first();
    }

    public function creerClient(string $numero): int
    {
        $this->insert([
            'numero_telephone' => $numero,
            'est_operateur'    => 0,
            'date_creation'    => date('Y-m-d H:i:s'),
            'solde'             => 0,
        ]);

        return (int) $this->getInsertID();
    }
}
