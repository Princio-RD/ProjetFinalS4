<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Acte extends Seeder
{
    public function run()
    {
        if ($this->db->table('Acte')->countAllResults() > 0) {
            return;
        }

        $data = [
            ['id_compte_source' => 1, 'id_compte_destination' => null, 'id_type_operation' => 1, 'montant' => 50000.00, 'frais_applique' => 0, 'statut' => 'Réussi'],
            ['id_compte_source' => 3, 'id_compte_destination' => null, 'id_type_operation' => 2, 'montant' => 10000.00, 'frais_applique' => 100, 'statut' => 'Réussi'],
            ['id_compte_source' => 1, 'id_compte_destination' => 2, 'id_type_operation' => 3, 'montant' => 25000.00, 'frais_applique' => 200, 'statut' => 'Réussi'],
            ['id_compte_source' => 5, 'id_compte_destination' => null, 'id_type_operation' => 2, 'montant' => 5000.00, 'frais_applique' => 50, 'statut' => 'Réussi'],
            ['id_compte_source' => 4, 'id_compte_destination' => 3, 'id_type_operation' => 3, 'montant' => 15000.00, 'frais_applique' => 150, 'statut' => 'Réussi'],
        ];

        $this->db->table('Acte')->insertBatch($data);
    }
}
