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

    public function rechercheParNumero(?string $numero = null): array
    {
        if ($numero === null || trim($numero) === '') {
            return $this->findAll();
        }

        return $this->like('numero', $numero)->findAll();
    }

    public function findByNumero(string $numero): ?array
    {
        return $this->where('numero', $numero)->first();
    }

    public function getSoldeUtilisateur(int $idUtilisateur): float
    {
        return (float) $this->select('solde')->where('id', $idUtilisateur)->first()['solde'];
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

    public function crediterSolde(int $idUtilisateur, float $montant): bool
    {
        $utilisateur = $this->find($idUtilisateur);
        if (!$utilisateur) {
            return false;
        }

        $nouveauSolde = $utilisateur['solde'] + $montant;
        return $this->update($idUtilisateur, ['solde' => $nouveauSolde]);
    }
}
