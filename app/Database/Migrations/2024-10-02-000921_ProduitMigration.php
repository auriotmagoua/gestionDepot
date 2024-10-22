<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProduitMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idProduit'          =>[
                'type'              =>'INT',
                'auto_increment'    =>true,
                'null'              =>false
            ],
            'qtyProduit'               =>[
                'type'              =>'INT',
                'null'              =>true
            ],
            'nameProduit'        =>[
                'type'              =>'TEXT',
                'null'              =>true
            ],
            'idCategorie'        =>[
                'type'              =>'INT',
                'null'              =>true
            ],
            'prixProduit'        =>[
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
            'created_at'         =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'updated_at'         =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ],
            'deleted_at'         =>[
                'type'              =>'TIMESTAMP',
                'null'              =>true
            ]
        ]);
        $this->forge->addPrimaryKey('idProduit');
        $this->forge->addForeignKey('idUser','users','idUser');
        $this->forge->addForeignKey('idCategorie','categorie','idCategorie');
        $this->forge->createTable('produit');
    }

    public function down()
    {
        $this->forge->dropTable('produit');
    }
}
