<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeOperateurModel extends Model
{
    protected $table            = 'prefixe';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'prefixe',
    ];

    protected $useTimestamps = false;

    public function getPrefixesValables(): array
    {
        return array_column($this->findAll(), 'prefixe');
    }

    public function numeroEstValide(string $numero): bool
    {
        if (!preg_match('/^0([0-9]{2})[0-9]{7}$/', $numero, $matches)) {
            return false;
        }

        $prefixe = $matches[1];

        return in_array($prefixe, $this->getPrefixesValables(), true);
    }
}
