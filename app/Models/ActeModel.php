<?php

namespace App\Models;

use CodeIgniter\Model;

class ActeModel extends Model
{
    protected $table = 'Acte';
    protected $primaryKey = 'id_acte';
    protected $allowedFields = [
        'id_compte_source',
        'id_compte_destination',
        'id_type_operation',
        'montant',
        'frais_applique',
        'statut'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'date_operation';
    protected $updatedField = '';
}