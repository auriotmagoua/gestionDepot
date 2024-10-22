<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'idUser';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idUser',
        'login',
        'password',
        'typeUser',
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

    public function getUser($loginUser, $passwd){
        $builder = $this->db->table('users');
        $builder->select("*");
        $builder->where('login', $loginUser);
        $builder->where('password', $passwd);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getUserById($idUser){
        $builder = $this->db->table('users');
        $builder->select("*");
        $builder->where('idUser', $idUser);
        $builder->where('is_delete', false);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getAllUser(){
        $builder = $this->db->table('users');
        $builder->select("*");
        $builder->where('is_delete', false);
        $builder->where('typeUser', 'user');
        $res  = $builder->get();
        return $res->getResultArray();
    }


}
