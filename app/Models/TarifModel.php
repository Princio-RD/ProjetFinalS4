<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifModel extends Model
{
    protected $table = 'Tarif';
    protected $primaryKey = 'id_bareme';
    protected $allowedFields = [
        'id_type_operation',
        'montant_min',
        'montant_max',
        'frais',
    ];
    protected $useTimestamps = false;

    public function calculerFrais(int $idTypeOperation, float $montant): float
    {
        $bareme = $this->where('id_type_operation', $idTypeOperation)
            ->where('montant_min <=', $montant)
            ->where('montant_max >=', $montant)
            ->first();

        return $bareme ? (float) $bareme['frais'] : 0.0;
    }
}
