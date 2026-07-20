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
            ['nom' => 'Jean','numero_telephone' => '0331562072'],
            ['nom' => 'Marie','numero_telephone' => '0348101301'],
            ['nom' => 'Pierre','numero_telephone' => '0321256078'],
            ['nom' => 'Sophie','numero_telephone' => '0335026660'],
            ['nom' => 'Luc','numero_telephone' => '0325877760'],
        ];

        $this->db->table('Client')->insertBatch($data);
    }
}
