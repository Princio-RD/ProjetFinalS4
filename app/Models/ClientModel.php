<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'Client';
    protected $primaryKey = 'id_client';
    protected $allowedFields = ['nom'];
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = '';
}