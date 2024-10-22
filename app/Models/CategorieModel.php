<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table            = 'categorie';
    protected $primaryKey       = 'idCategorie';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idCategorie',
        'nameCategorie',
        'nombreBouteille',
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


    // verifier si une categorie existe deja
    public function getCategorie($nameCategorie, $nombreBouteille){
        $builder = $this->db->table('categorie');
        $builder->select("*");
        $builder->where('nameCategorie', $nameCategorie);
        $builder->where('nombreBouteille', $nombreBouteille);
        $builder->where('is_delete', false);
        $res  = $builder->get();
        return $res->getResultArray();
    }

    // recupere tout les categories
    public function getAllCategorie()
    {
        $builder = $this->db->table('categorie');
        $builder->select("*");
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    // recuperer un categorie particuliere par son Id
    public function getCategorieById($idCategorie){
        $builder = $this->db->table('categorie');
        $builder->select("*");
        $builder->where('idCategorie', $idCategorie);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }


}
