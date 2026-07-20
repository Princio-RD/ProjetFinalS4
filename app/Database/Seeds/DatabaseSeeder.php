<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
       
        $this->call('Operateur');
        $this->call('Operation');
        $this->call('Tarif');
        $this->call('Client');
        $this->call('Compte');
        $this->call('Acte');
    }
}
