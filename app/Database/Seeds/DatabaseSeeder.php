<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(Operateur::class);
        $this->call(Operation::class);
        $this->call(Client::class);
        $this->call(Compte::class);
        $this->call(Tarif::class);
        $this->call(Commission::class);
        $this->call(Acte::class);
    }
}
