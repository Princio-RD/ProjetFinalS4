<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Commission extends Seeder
{
    public function run()
    {
        if ($this->db->table('Commission')->countAllResults() > 0) {
            return;
        }

        $data = [
            ['id_operateur_source' => 1, 'id_operateur_destination' => 2, 'pourcentage' => 2.50],
            ['id_operateur_source' => 1, 'id_operateur_destination' => 3, 'pourcentage' => 3.00],
            ['id_operateur_source' => 2, 'id_operateur_destination' => 1, 'pourcentage' => 2.00],
            ['id_operateur_source' => 2, 'id_operateur_destination' => 3, 'pourcentage' => 2.50],
            ['id_operateur_source' => 3, 'id_operateur_destination' => 1, 'pourcentage' => 3.50],
            ['id_operateur_source' => 3, 'id_operateur_destination' => 2, 'pourcentage' => 3.00],
        ];

        $this->db->table('Commission')->insertBatch($data);
    }
}