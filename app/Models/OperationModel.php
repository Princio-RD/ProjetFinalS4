<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'Operation';
    protected $primaryKey = 'id_type_operation';
    protected $allowedFields = ['libelle'];
    protected $useTimestamps = false;
}