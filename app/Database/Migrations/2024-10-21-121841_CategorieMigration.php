<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategorieMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idCategorie'          =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'nameCategorie'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'nombreBouteille'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'idUser'           =>[
                'type'              =>'INT',
                'null'              =>true
            ],
            'is_enable'        =>[
                'type'              =>'BOOLEAN',
                'null'              =>true
            ],
            'is_delete'        =>[
                'type'              =>'BOOLEAN',
                'null'              =>true
            ],
            'created_at'       =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'updated_at'       =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'deleted_at'       =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ]
        ]);
        $this->forge->addPrimaryKey('idCategorie');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->createTable('categorie');
    }

    public function down()
    {
        $this->forge->dropTable('categorie');
    }
}
