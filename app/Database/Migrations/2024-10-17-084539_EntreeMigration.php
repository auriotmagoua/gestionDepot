<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EntreeMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idEntree'         =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'qtyEntree'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'qtyEmballageEntree'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'idProduit'        =>[
                'type'              =>'INT',
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
        $this->forge->addPrimaryKey('idEntree');
        $this->forge->addForeignKey('idProduit','produit','idProduit');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->createTable('entree');
    }

    public function down()
    {
        $this->forge->dropTable('entree');
    }
}
