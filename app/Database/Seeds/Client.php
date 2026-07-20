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
            ['numero_telephone' => '0331562072'],
            ['numero_telephone' => '0348101301'],
            ['numero_telephone' => '0321256078'],
            ['numero_telephone' => '0335026660'],
            ['numero_telephone' => '0325877760'],
        ];

        $this->db->table('Client')->insertBatch($data);
    }
}
