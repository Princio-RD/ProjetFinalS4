<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Operation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_type_operation' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'libelle' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => false,
                'unique'     => true,
            ],
        ]);
        $this->forge->addKey('id_type_operation', true);
        $this->forge->createTable('Operation');
    }

    public function down()
    {
        $this->forge->dropTable('Operation', true);
    }
}
