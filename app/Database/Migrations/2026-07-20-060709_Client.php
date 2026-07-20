<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Client extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_client' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'numero_telephone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => false,
                'unique'     => true,
            ],
            'date_creation' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_client', true);
        $this->forge->createTable('Client');
    }

    public function down()
    {
        $this->forge->dropTable('Client', true);
    }
}
