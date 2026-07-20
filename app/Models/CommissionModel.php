<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'Commission';
    protected $primaryKey = 'id_commission';
    protected $allowedFields = [
        'id_operateur_source',
        'id_operateur_destination',
        'pourcentage'
    ];
    protected $useTimestamps = false;

    public function getCommission($idSource, $idDestination)
    {
        $result = $this->where('id_operateur_source', $idSource)
                       ->where('id_operateur_destination', $idDestination)
                       ->first();
        
        if ($result) {
            return (float) $result['pourcentage'];
        }

        $resultInverse = $this->where('id_operateur_source', $idDestination)
                              ->where('id_operateur_destination', $idSource)
                              ->first();

        return $resultInverse ? (float) $resultInverse['pourcentage'] : 0;
    }

    public function getAllCommissions()
    {
        return $this->select('Commission.*, 
                             OperateurSource.nom as source_nom, OperateurSource.prefixe as source_prefixe,
                             OperateurDest.nom as dest_nom, OperateurDest.prefixe as dest_prefixe')
                    ->join('Operateur as OperateurSource', 'OperateurSource.id_operateur = Commission.id_operateur_source')
                    ->join('Operateur as OperateurDest', 'OperateurDest.id_operateur = Commission.id_operateur_destination')
                    ->findAll();
    }
}