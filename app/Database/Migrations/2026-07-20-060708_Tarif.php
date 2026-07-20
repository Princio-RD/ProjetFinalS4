<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tarif extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bareme' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_type_operation' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'montant_min' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'montant_max' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'frais' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id_bareme', true);
        $this->forge->addForeignKey('id_type_operation', 'Operation', 'id_type_operation', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Tarif');
    }

    public function down()
    {
        $this->forge->dropTable('Tarif', true);
    }
}
