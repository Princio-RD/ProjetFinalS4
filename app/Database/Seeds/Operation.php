<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Operation extends Seeder
{
    public function run()
    {
        $data = [
            ['libelle' => 'Dépôt'],
            ['libelle' => 'Retrait'],
            ['libelle' => 'Transfert'],
        ];

        $this->db->table('Operation')->insertBatch($data);
    }
}
