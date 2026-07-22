<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'Operateur';
    protected $primaryKey = 'id_operateur';
    protected $allowedFields = ['nom', 'prefixe'];
    protected $useTimestamps = false;
}