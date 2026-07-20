<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Operation extends Seeder
{
    public function run()
    {
        if ($this->db->table('Operation')->countAllResults() > 0) {
            return;
        }

        $data = [
            ['libelle' => 'Dépôt'],
            ['libelle' => 'Retrait'],
            ['libelle' => 'Transfert'],
        ];

        $this->db->table('Operation')->insertBatch($data);
    }
}
