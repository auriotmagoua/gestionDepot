<?php

namespace App\Models;

use CodeIgniter\Model;

class FournisseurModel extends Model
{
    protected $table            = 'fournisseur';
    protected $primaryKey       = 'idFournisseur';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idFournisseur',
        'nameFournisseur',
        'phoneFournisseur',
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



    public function getFournisseurByNamePhone($name, $phone)
    {
        $builder = $this->db->table('fournisseur');
        $builder->select("*");
        $builder->where('nameFournisseur', $name);
        $builder->where('phoneFournisseur', $phone);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }


    public function getAllFournisseur()
    {
        $builder = $this->db->table('fournisseur');
        $builder->select("*");
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }


    // recuperer un fournisseur particulier
    public function getFournisseurById($idFournis){
        $builder = $this->db->table('fournisseur');
        $builder->select("*");
        $builder->where('idFournisseur', $idFournis);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }
}
