<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Commission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_commission' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_operateur_source' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'id_operateur_destination' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'pourcentage' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id_commission', true);
        $this->forge->addUniqueKey(['id_operateur_source', 'id_operateur_destination']);
        $this->forge->addForeignKey('id_operateur_source', 'Operateur', 'id_operateur', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_operateur_destination', 'Operateur', 'id_operateur', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Commission');
    }

    public function down()
    {
        $this->forge->dropTable('Commission');
    }
}