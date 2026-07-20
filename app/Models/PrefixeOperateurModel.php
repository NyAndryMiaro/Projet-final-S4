<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeOperateurModel extends Model
{
    protected $table            = 'prefixe_operateur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'prefixe',
    ];

    protected $useTimestamps = false;

    public function getPrefixesValables(): array
    {
        return array_column($this->findAll(), 'prefixe_operateur');
    }

    public function numeroEstValide(string $numero): bool
    {
        if (!preg_match('/^0([0-9]{2})[0-9]{7}$/', $numero, $matches)) {
            return false;
        }

        $prefixe = $matches[1];

        $prefixesValables = $this->getPrefixesValables();
        foreach ($prefixesValables as $prefixeValable) {
            if ($prefixe === $prefixeValable) {
                return true;
            }
        }

        return false;
    }

    public function verifierDeuxPrefixes($num1, $num2) : bool
    {
        $prefixe1 = substr($num1, 0, 3);
        $prefixe2 = substr($num2, 0, 3);

        return $prefixe1 === $prefixe2;
    }

}
