<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommissionToActe extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Acte', [
            'commission_appliquee' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
                'default'    => 0,
                'after'      => 'frais_applique',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('Acte', 'commission_appliquee');
    }
}
