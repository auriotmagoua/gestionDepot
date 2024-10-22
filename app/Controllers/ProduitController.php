<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProduitModel;
use App\Models\EntreeModel;
use App\Controllers\History;

include('History/HistorySession.php');

class ProduitController extends ResourcePresenter
{
    use ResponseTrait;

    public function list(){
        $ProduitModel = new ProduitModel();

        $data = $ProduitModel->getAllProduit();

        return $this->respond($data);
    }

    public function entreeProduct(){
        // sauvegarder dans la table entree
        /*$data_entree = [
            'qty_entree'    => $this->request->getVar('qty'),
            'prix_entree'   => $this->request->getVar('prixProduit'),
            'idUser'        => $idUser,
            'is_enable'     => date("Y-m-d H:i:s"),
            'created_at'    => date("Y-m-d H:i:s"),
        ];
        $EntreeModel->save($data);*/
    }

    public function save(){
        $rules = [
            'nameProduit'   => 'required|trim|is_unique[produit.nameProduit]',
            'prixProduit'   => 'required',
            'idCategorie'   => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new ProduitModel();

            $nameProduit     = $this->request->getVar('nameProduit');
            $idCategorie     = $this->request->getVar('idCategorie');
            $prixProduit     = $this->request->getVar('prixProduit');


            // session
            $HistorySession = new HistorySession();
            $data_session = $HistorySession->getInfoSession();
            $idUser = $data_session['idUser'];
            $data_produit = $model->getProduit($nameProduit, $idCategorie,$prixProduit);
            
            if (sizeof($data_produit) != 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'Le produit existe déjà',
                ];
                return $this->respond($response);
            }else {

                $data = [
                    'qtyProduit'   => $this->request->getVar('quantite'),
                    'nameProduit'  => $this->request->getVar('nameProduit'),
                    'idCategorie'  => $this->request->getVar('idCategorie'),
                    'prixProduit'  => $this->request->getVar('prixProduit'), 
                    'idUser'       => $idUser, 
                    'created_at'   => date("Y-m-d H:i:s"),
                    'is_enable'    => true,
                    'is_delete'    => false,
                ];
                $model->save($data);
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "success",
                    "title"   => "Réussite",
                    "autorisation"   => true,
                    "msg"     => "Produit enregistré avec succès"
                ];
                return $this->respond($response);
            }
        }else {
            $response = [
                "success"  => false,
                "status"   => 400,
                "code"     => "error",
                "title"    => "Erreur de validation",
                "error"    => $this->validator->getErrors(), 
                "msg"      => "Erreur de validation", 
            ];
            return $this->respond($response);
        }
    }

    public function deleteProduit($id){

        $ProduitModel = new ProduitModel(); 
        $data = $ProduitModel->getProduitById($id);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Ce produit n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($ProduitModel->where('idProduit', $id)->set($data)->update() === false) {
                  $response = [
                      "success"   => false,
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        'msg'     => "Echec de suppression",
                    ];
                  
                    return $this->respond($response);
            }else{
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "Success",
                    "title"   => "Réussite",
                    'msg'     => "Suppression reussie",
                ];
                return $this->respond($response);
            
            }   
                    
        }
    }


    // modifier un produit
    public function updateProduit(){

        $rules = [
            'nameProduitU'          => 'required',
            'idCategorieU'          => 'required',
            'prixProduitU'          => 'required',
            'idProduitU'            => 'required'
        ];

        if ($this->validate($rules)) {
            $ProduitModel = new ProduitModel(); 

            $nameProduit = $this->request->getVar('nameProduitU');
            $idCategorieU = $this->request->getVar('idCategorieU');
            $prixProduit = $this->request->getVar('prixProduitU');
            $idProduit = $this->request->getVar('idProduitU');
            
            $data_produit = $ProduitModel->getProduitById($idProduit);

            if (sizeof($data_produit) == 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    'msg'     => "ce produit n'existe pas",
                ];
                return $this->respond($response);
            }else{ 
    
                $data = [
                    'nameProduit'   => $nameProduit ,
                    'idCategorieU'  => $idCategorieU,
                    'prixProduit'   => $prixProduit,
                    'idProduit'     => $idProduit,
                    'updated_at'        => date("Y-m-d H:m:s")
                ];
                if ($ProduitModel->where('idProduit', $idProduit)->set($data)->update() === false) {
                    $response = [
                        "success" => false,
                            "status"  => 500,
                            "code"    => "error",
                            "title"   => "Erreur",
                            'msg'     => "Echec de modification",
                        ];
                    
                        return $this->respond($response);
                }else{
                    $newProduit = $ProduitModel->getProduitById($idProduit);
                    $response = [
                        "success" => true,
                        "status"  => 200,
                        "code"    => "Success",
                        "title"   => "Réussite",
                        'msg'     => "Modification réussie",
                        'data'    => $newProduit[0]
                    ];  
                    return $this->respond($response);
                
                }   
            }
        } else {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Echec de modification du produit",
                "error"    => $this->validator->getErrors(), 
            ];

            return $this->respond($response);
        }
    }


    public function getOne($id){
        $ProduitModel = new ProduitModel(); 
        $data = $ProduitModel->getProduitById($id);
        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "msg"     => "Une erreur est survenue",
                "data"    => null 
            ];
            return $this->respond($response);
        }

        $response = [
            "success" => true,
            "status"  => 200,
            "msg"     => "Opération réussie",
            "data"    => $data[0] 
        ];

        return $this->respond($response);
        
    }

    function numbreProduit(){
        $ProduitModel = new ProduitModel();
        $number = $ProduitModel->getNumberProduit();

        return $this->respond($number);
    }
}
