<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'client';
    protected $primaryKey       = 'idClient';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idClient',
        'nameClient',
        'phoneClient',
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

    // recuperer tout les clients
    public function getClient($name, $phone)
    {
        $builder = $this->db->table('client');
        $builder->select("*");
        $builder->where('nameClient', $name);
        $builder->where('phoneClient', $phone);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getAllClient()
    {
        $builder = $this->db->table('client');
        $builder->select("*");
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    // recuperer un client particulier
    public function getClientById($idClient){
        $builder = $this->db->table('client');
        $builder->select("*");
        $builder->where('idClient', $idClient);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

}
