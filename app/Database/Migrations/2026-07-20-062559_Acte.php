<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Acte extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_acte' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_compte_source' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_compte_destination' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_type_operation' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'frais_applique' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
                'default'    => 0,
            ],
            'date_operation' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'statut' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
                'default'    => 'Réussi',
            ],
        ]);
        $this->forge->addKey('id_transaction', true);
        $this->forge->addForeignKey('id_compte_source', 'Compte', 'id_compte', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_compte_destination', 'Compte', 'id_compte', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_type_operation', 'Operation', 'id_type_operation', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Transaction');
    }

    public function down()
    {
        $this->forge->dropTable('Transaction', true);
    }
}
