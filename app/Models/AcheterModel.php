<?php

namespace App\Models;

use CodeIgniter\Model;

class AcheterModel extends Model
{
    protected $table            = 'acheter';
    protected $primaryKey       = 'idAcheter';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idAcheter',
        'prix',
        'quantite',
        'nameAcheter',
        'remise',
        'phone',
        'idProduit',
        'idClient',
        'idUser',
        'numAcheter',
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

    // recuperer tout les achats du jours
    public function getAllAchatDay($date){

        $builder = $this->db->table('acheter a');
        $builder->select('*');
        $builder->where('a.is_delete', false);
        $builder->where('a.created_at >=', $date . ' 00:00:00');
        $builder->where('a.created_at <=', $date . ' 23:59:59');
        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function generateNumAchat() {
        $AcheterModel = new AcheterModel();
        
        $lastEntry = $AcheterModel->orderBy('idAcheter', 'DESC')->first();
    
        if ($lastEntry && isset($lastEntry['numAcheter'])) {
            $lastNumAchat = $lastEntry['numAcheter'];
    
            $parts = explode('-', $lastNumAchat);
            
            if (isset($parts[1])) {
                $lastNum = (int) $parts[1]; 
                $newNum = $lastNum + 1; 
            } else {
                $newNum = 1;
            }
        } else {
            // Si aucune entrée n'existe, commencer à 1
            $newNum = 1;
        }
    
        // Formater le nouveau numéro avec des zéros à gauche
        $newNumAchat = 'fact-' . str_pad($newNum, 4, '0', STR_PAD_LEFT);
        
        return $newNumAchat;
    }    
    
    public function getVenteByNumFact($numAcheter)
    {
        $builder = $this->db->table('acheter');
        $builder->select("*");
        $builder->where('is_delete', false);
        $builder->where('numAcheter', $numAcheter);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    // recuperer les ventes dune facture
    // public function getOneVente($numAcheter){
    //     $builder = $this->db->table('acheter a');
    //     $builder->select("*");
    //     $builder->join('produit p', 'p.idProduit = a.idProduit'); 
    //     $builder->where('a.numAcheter',$numAcheter);
    //     $builder->where('a.is_delete', false);
    //     // $builder->join('payement py', 'py.numAcheter = a.numAcheter'); 
    //     $builder->groupBy('a.numAcheter');
    //     $builder->orderBy('a.idAcheter','DESC');

    //     $res  = $builder->get();
    //     return $res->getResultArray();
    // } 
    
    
    public function getAllProduitFact($numfact){
        $builder = $this->db->table('produit');
        $builder->select("*");
        $builder->join('acheter','acheter.idProduit = produit.idProduit');
        $builder->where('acheter.is_delete', false);
        $builder->where('numAcheter', $numfact);

        $res  = $builder->get();
        return $res->getResultArray();
    }

    public function getDistinctAllFactByIDClient($id_client){
        $builder = $this->db->table('acheter a');
        
        $builder->select('DISTINCT(numAcheter),nameAcheter,phone,created_at, idClient');
        
        $builder->where('a.idClient', $id_client);
        $builder->where('a.is_delete', false);
        $builder->orderBy('a.idAcheter', 'DESC');
    
        $res = $builder->get();
        return $res->getResultArray();
    }

    public function getDistinctAllFact(){
        $builder = $this->db->table('acheter a');
        
        $builder->select('DISTINCT(numAcheter),nameAcheter,phone,created_at');
        
        // Ajouter les jointures
        // $builder->join('produit p', 'p.idProduit = a.idProduit', 'LEFT'); 
    
        $builder->where('a.is_delete', false);
        // $builder->groupBy('a.numAcheter');
        $builder->orderBy('a.idAcheter', 'DESC');
    
        $res = $builder->get();
        return $res->getResultArray();
    }

    public function getDistinctOneFact($numAcheter){
        $builder = $this->db->table('acheter a');
        
        $builder->select('DISTINCT(numAcheter),nameAcheter,phone,created_at, prix, quantite, remise');
        $builder->where('a.is_delete', false);
        $builder->where('a.numAcheter', $numAcheter);
        $builder->orderBy('a.idAcheter', 'DESC');
    
        $res = $builder->get();
        return $res->getResultArray();
    }
    
    // recuperer tout les numeros de facture
    public function getAllNumFact(){

        $builder = $this->db->table('acheter a');
        $builder->select('numAcheter');
        $builder->groupBy('numAcheter');
        $builder->orderBy('numAcheter','DESC');
        $builder->where('a.is_delete', false);
        $res  = $builder->get();
        return $res->getResultArray();

    }

    public function montantNumFactAcheter($numAcheter) {
        $builder = $this->db->table('acheter a');
        $builder->select('SUM(prix * quantite) AS total_montant'); // Calcule le montant total
        $builder->where('a.numAcheter', $numAcheter);
        $builder->where('a.is_delete', false);
        $res = $builder->get();
    
        // Vérifie si le résultat existe et retourne le montant total
        $result = $res->getRow();
        return $result ? $result->total_montant : 0; // Retourne 0 si aucun résultat
    }
    

}
