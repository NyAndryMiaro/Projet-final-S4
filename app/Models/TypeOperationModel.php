<?php namespace App\Models;
use CodeIgniter\Model;

class TypeOperationModel extends Model
{
    protected $table = 'type_operation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $returnType = 'array';

    public function getByNom(string $nom)
    {
        return $this->where('nom', $nom)->first();
    }
}