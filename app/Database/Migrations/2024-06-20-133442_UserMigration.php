<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idUser'          =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'login'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'password'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'typeUser'        =>[
                'type'              =>'TEXT',
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
        $this->forge->addPrimaryKey('idUser');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
