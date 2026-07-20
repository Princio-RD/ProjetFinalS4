<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Client extends Seeder
{
    public function run()
    {
        if ($this->db->table('Client')->countAllResults() > 0) {
            return;
        }

        $data = [
            ['nom' => 'Jean'],
            ['nom' => 'Rakoto'],
            ['nom' => 'Rabe'],
            ['nom' => 'Karl'],
            ['nom' => 'Marie'],
        ];

        $this->db->table('Client')->insertBatch($data);
    }
}
