<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Operateur extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_operateur' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'prefixe' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'null'       => false,
                'unique'     => true,
            ],
        ]);
        $this->forge->addKey('id_operateur', true);
        $this->forge->createTable('Operateur');
    }

    public function down()
    {
        $this->forge->dropTable('Operateur', true);
    }
}
