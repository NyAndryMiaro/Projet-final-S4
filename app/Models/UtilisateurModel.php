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
        'numero',
        'est_operateur',
        'solde'
    ];

    protected $useTimestamps = false;
    public function findByNumero(string $numero): ?array
    {
        return $this->where('numero', $numero)->first();
    }

    public function creerClient(string $numero): int
    {
        $this->insert([
            'numero' => $numero,
            'est_operateur'    => 0,
            'solde'             => 0
        ]);

        return (int) $this->getInsertID();
    }
}
