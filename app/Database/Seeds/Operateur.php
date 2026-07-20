<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Operateur extends Seeder
{
    public function run()
    {
        $data = [
            ['nom' => 'Orange', 'prefixe' => '032'],
            ['nom' => 'Telma', 'prefixe' => '034'],
            ['nom' => 'Airtel', 'prefixe' => '033'],
        ];

        $this->db->table('Operateur')->insertBatch($data);
    }
}
