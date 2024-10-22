<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SortieMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idSortie'          =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'qtySortie'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'qtyEmballageSortie'        =>[
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
        $this->forge->addPrimaryKey('idSortie');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->addForeignKey('idProduit','produit','idProduit');
        $this->forge->createTable('sortie');
    }

    public function down()
    {
        $this->forge->dropTable('sortie');
    }
}
