<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'Transaction';
    protected $primaryKey = 'id_transaction';
    protected $allowedFields = [
        'id_compte_source',
        'id_compte_destination',
        'id_type_operation',
        'montant',
        'frais_applique',
        'statut',
    ];
    protected $useTimestamps = false;
}
