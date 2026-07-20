<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Compte extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_compte' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_client' => [
                'type'       => 'INTEGER',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_operateur' => [
                'type'       => 'INTEGER',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'solde' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
                'default'    => 0,
            ],
        ]);
        $this->forge->addKey('id_compte', true);
        $this->forge->addForeignKey('id_client', 'Client', 'id_client', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_operateur', 'Operateur', 'id_operateur', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Compte');
    }

    public function down()
    {
        $this->forge->dropTable('Compte', true);
    }
}
