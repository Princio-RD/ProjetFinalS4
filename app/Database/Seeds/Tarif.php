<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tarif extends Seeder
{
    public function run()
    {
        if ($this->db->table('Tarif')->countAllResults() > 0) {
            return;
        }

        $data = [
            ['id_type_operation' => 1, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['id_type_operation' => 1, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['id_type_operation' => 1, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['id_type_operation' => 1, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['id_type_operation' => 1, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['id_type_operation' => 1, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],
            ['id_type_operation' => 1, 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500],
            ['id_type_operation' => 1, 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500],
            ['id_type_operation' => 1, 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500],
            ['id_type_operation' => 1, 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
            ['id_type_operation' => 2, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['id_type_operation' => 2, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['id_type_operation' => 2, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['id_type_operation' => 2, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['id_type_operation' => 2, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['id_type_operation' => 2, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],
            ['id_type_operation' => 2, 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500],
            ['id_type_operation' => 2, 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500],
            ['id_type_operation' => 2, 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500],
            ['id_type_operation' => 2, 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
            // Barème des frais pour les transferts (id_type_operation = 3)
            ['id_type_operation' => 3, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['id_type_operation' => 3, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['id_type_operation' => 3, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['id_type_operation' => 3, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['id_type_operation' => 3, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['id_type_operation' => 3, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],
            ['id_type_operation' => 3, 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500],
            ['id_type_operation' => 3, 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500],
            ['id_type_operation' => 3, 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500],
            ['id_type_operation' => 3, 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
        ];

        $this->db->table('Tarif')->insertBatch($data);
    }
}
