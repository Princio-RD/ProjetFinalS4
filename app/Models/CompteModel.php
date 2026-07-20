<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'Compte';
    protected $primaryKey = 'id_compte';
    protected $allowedFields = ['id_client', 'id_operateur', 'solde'];
    protected $useTimestamps = false;
}