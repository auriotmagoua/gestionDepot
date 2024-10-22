<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table            = 'produit';
    protected $primaryKey       = 'idProduit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idProduit',
        'idParent',
        'qtyProduit',
        'nameProduit',
        'idCategorie',
        'prixProduit',
        'idUser',
        'is_enable',
        'is_delete',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllProduit(){
        $builder = $this->db->table('produit');
        $builder->select("*");
        $builder->join('categorie','produit.idCategorie = categorie.idCategorie');
        $builder->where('produit.is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getProduitById($id){
        $builder = $this->db->table('produit');
        $builder->select("*");
        $builder->where('idProduit', $id);
        $builder->join('categorie','produit.idCategorie = categorie.idCategorie');
        $builder->where('produit.is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getProduit($name, $idCategorie, $prix){
        $builder = $this->db->table('produit');
        $builder->select("*");
        $builder->where('nameProduit', $name);
        $builder->where('idCategorie', $idCategorie);
        $builder->where('prixProduit', $prix);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }


    public function getNumberProduit(){
        $builder = $this->db->table('produit');
        $builder->select("COUNT(idProduit) AS nombre_prod");
        $builder->where('is_delete', false);
        $res = $builder->get();

        $result = $res->getRow();
        return $result ? $result->nombre_prod : 0; 
    }
     
}
