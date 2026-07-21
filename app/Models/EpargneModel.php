<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModelcteModel extends Model
{
    protected $table = 'Epargne';
    protected $primaryKey = 'id_epargene';
    protected $allowedFields = [
        'id_compte_source',
        'id_compte_destination',
        'id_type_operation',
        'montant',
        'frais_applique',
        'commission_appliquee',
        'statut'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'date_operation';
    protected $updatedField = '';
}