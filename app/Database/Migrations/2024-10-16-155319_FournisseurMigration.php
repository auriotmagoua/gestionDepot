<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FournisseurMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idFournisseur'       =>[
                'type'            =>'INT',
                'auto_increment'  =>true,
                'null'            =>false
            ],
            'nameFournisseur'     =>[
                'type'            =>'TEXT',
                'null'            =>true
            ],
            'phoneFournisseur'         =>[
                'type'            =>'TEXT',
                'null'            =>true
            ],
            'idUser'              =>[
                'type'            =>'INT',
                'null'            =>true
            ],
            'is_enable'           =>[
                'type'            =>'BOOLEAN',
                'null'            =>true
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
        $this->forge->addPrimaryKey('idFournisseur');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->createTable('fournisseur');
    }

    public function down()
    {
        $this->forge->dropTable('fournisseur');
    }
}
