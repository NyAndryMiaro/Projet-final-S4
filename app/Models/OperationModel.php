<?php namespace App\Models;
use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operation';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_type_operation', 'valeur', 'frais',
        'envoyeur', 'destinataire', 'date_operation'
    ];
    protected $returnType = 'array';

    public function totalGains(?string $periode = null): float
    {
        $builder = $this->db->table('operation o')
            ->selectSum('o.frais', 'total')
            ->join('type_operation t', 't.id = o.id_type_operation')
            ->whereIn('t.nom', ['retrait', 'transfert']);

        if ($periode === 'jour') {
            $builder->where('DATE(o.date_operation)', date('Y-m-d'));
        } elseif ($periode === 'semaine') {
            $builder->where('o.date_operation >=', date('Y-m-d', strtotime('-7 days')));
        } elseif ($periode === 'mois') {
            $builder->where("strftime('%Y-%m', o.date_operation) = '" . date('Y-m') . "'", null, false);
        }

        $row = $builder->get()->getRowArray();
        return $row['total'] ? (float) $row['total'] : 0.0;
    }

    public function historiqueUtilisateur(int $idUtilisateur): array
    {
        return $this->db->table('operation o')
            ->select('o.*, t.nom as type_nom')
            ->join('type_operation t', 't.id = o.id_type_operation')
            ->groupStart()
                ->where('o.envoyeur', $idUtilisateur)
                ->orWhere('o.destinataire', $idUtilisateur)
            ->groupEnd()
            ->orderBy('o.date_operation', 'DESC')
            ->get()
            ->getResultArray();
    }
}