<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifModel extends Model
{
    protected $table = 'Tarif';
    protected $primaryKey = 'id_bareme';
    protected $allowedFields = ['id_type_operation', 'montant_min', 'montant_max', 'frais'];
    protected $useTimestamps = false;
}