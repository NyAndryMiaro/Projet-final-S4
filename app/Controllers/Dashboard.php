<?php

namespace App\Controllers;

use Throwable;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $gains_locaux = 0.0;
        $gains_inter_operateurs = 0.0;
        $total_gains = 0.0;
        $pourcentage_commission = 0.0;
        $situation_operateurs = [];
        $error = null;

        try {
            $configQuery = $db->query("SELECT pourcentage FROM config_commission_inter_operateur ORDER BY id DESC LIMIT 1")->getRow();
            if ($configQuery) {
                $pourcentage_commission = (float) $configQuery->pourcentage;
            }

            $gainsLocauxQuery = $db->query("SELECT COALESCE(SUM(frais), 0) as total FROM operation")->getRow();
            if ($gainsLocauxQuery) {
                $gains_locaux = (float) $gainsLocauxQuery->total;
            }

            $gainsInterQuery = $db->query("
                SELECT COALESCE(SUM(valeur * (CAST(? AS REAL) / 100)), 0) as total 
                FROM operation 
                WHERE id_autre_operateur IS NOT NULL
            ", [$pourcentage_commission])->getRow();
            
            if ($gainsInterQuery) {
                $gains_inter_operateurs = (float) $gainsInterQuery->total;
            }

            $total_gains = $gains_locaux + $gains_inter_operateurs;

            $situation_operateurs = $db->query("
                SELECT 
                    p.nom_operateur,
                    p.prefixe,
                    COUNT(o.id) as nb_operations,
                    COALESCE(SUM(o.valeur), 0) as total_envoye,
                    COALESCE(SUM(o.valeur * (CAST(? AS REAL) / 100)), 0) as commission_due,
                    COALESCE(SUM(o.valeur + (o.valeur * (CAST(? AS REAL) / 100))), 0) as net_a_reverser
                FROM prefixe_autre_operateur p
                LEFT JOIN operation o ON o.id_autre_operateur = p.id
                GROUP BY p.id, p.nom_operateur, p.prefixe
                ORDER BY p.nom_operateur ASC
            ", [$pourcentage_commission, $pourcentage_commission])->getResultArray();

        } catch (Throwable $e) {
            $error = "Erreur lors du chargement des données : " . $e->getMessage();
            log_message('error', 'Dashboard index error: {message}', ['message' => $e->getMessage()]);
        }

        return view('operateur/dashboard', [
            'gains_locaux'            => $gains_locaux,
            'gains_inter_operateurs'  => $gains_inter_operateurs,
            'total_gains'             => $total_gains,
            'pourcentage_commission' => $pourcentage_commission,
            'situation_operateurs'   => $situation_operateurs,
            'error'                  => $error
        ]);
    }
}