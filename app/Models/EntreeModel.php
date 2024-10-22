<?php

namespace App\Models;

use CodeIgniter\Model;

class EntreeModel extends Model
{
    protected $table            = 'entree';
    protected $primaryKey       = 'idEntree';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idEntree',
        'qtyEntree',
        'qtyEmballageEntree',
        'idProduit',
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

    public function getNombreBoutProdById($produit){
        $builder = $this->db->table('produit');
        $builder->select("nombreBouteille");
        $builder->where('idProduit', $produit);
        $builder->join('categorie','produit.idCategorie = categorie.idCategorie');
        $builder->where('categorie.is_delete', false);
        $builder->where('produit.is_delete', false);
        $res  = $builder->get();
        return $res->getResultArray();
    }
}
