<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClientMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idClient'          =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'nameClient'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'phoneClient'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'idUser'             =>[
                'type'              =>'INT',
                'null'              =>true
            ],
            'is_enable'          =>[
                'type'              =>'BOOLEAN',
                'null'              =>true
            ],
            'is_delete'          =>[
                'type'              =>'BOOLEAN',
                'null'              =>true
            ],
            'created_at'          =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'updated_at'          =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'deleted_at'          =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ]
        ]);
        $this->forge->addPrimaryKey('idClient');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->createTable('client');
    }

    public function down()
    {
        $this->forge->dropTable('client');
    }
}
