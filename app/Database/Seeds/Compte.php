<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Compte extends Seeder
{
    public function run()
    {
        $data = [
            ['id_client' => 1, 'id_operateur' => 1, 'solde' => 50000.00],
            ['id_client' => 1, 'id_operateur' => 2, 'solde' => 25000.00],
            ['id_client' => 2, 'id_operateur' => 1, 'solde' => 100000.00],
            ['id_client' => 2, 'id_operateur' => 3, 'solde' => 15000.00],
            ['id_client' => 3, 'id_operateur' => 2, 'solde' => 75000.00],
            ['id_client' => 4, 'id_operateur' => 1, 'solde' => 30000.00],
            ['id_client' => 4, 'id_operateur' => 3, 'solde' => 12000.00],
            ['id_client' => 5, 'id_operateur' => 2, 'solde' => 90000.00],
        ];

        $this->db->table('Compte')->insertBatch($data);
    }
}
