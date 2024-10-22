<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategorieModel;
use App\Controllers\History;
include('History/HistorySession.php');

class CategorieController extends ResourcePresenter
{ 
    use ResponseTrait;
    
    public function list(){
        $CategorieModel = new CategorieModel();

        $data = $CategorieModel->getAllCategorie();

        return $this->respond($data);
    }

    public function save(){
        $rules = [
            'nameCategorie'   => 'required|trim|is_unique[produit.nameProduit]',
            'nombreBouteille'   => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new CategorieModel();

            $nameCategorie      = $this->request->getVar('nameCategorie');
            $nombreBouteille    = $this->request->getVar('nombreBouteille');


            // session
            $HistorySession = new HistorySession();
            $data_session = $HistorySession->getInfoSession();
            $idUser = $data_session['idUser'];
            $data_categorie = $model->getCategorie($nameCategorie, $nombreBouteille);
            
            if (sizeof($data_categorie) != 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'La categorie existe déjà',
                ];
                return $this->respond($response);
            }else {

                $data = [
                    'nameCategorie'    => $nameCategorie,
                    'nombreBouteille'  => $nombreBouteille,
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
                    "msg"     => "Categorie enregistré avec succès"
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

    // supprimer une categorie 
    public function deleteCategorie($idCategorie){

        $CategorieModel = new CategorieModel(); 
        $data = $CategorieModel->getCategorieById($idCategorie);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Cette categorie  n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
    
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($CategorieModel->where('idCategorie', $idCategorie)->set($data)->update() === false) {
                    $response = [
                        "success" => false,
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

    // recuperer les infos d'une seule categorie pour modifier
    public function getOne($id){
        $CategorieModel = new CategorieModel(); 
        $data = $CategorieModel->getCategorieById($id);
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

    // modifier une categorie
    public function updateCategorie(){

        $rules = [
            'idCategorieU'        => 'required',
            'nameCategorieU'      => 'required',
            'nombreBouteilleU'    => 'required'

        ];

        if ($this->validate($rules)) {
            $model = new CategorieModel(); 

            $idCategorie = $this->request->getVar('idCategorieU');
            $nameCategorie = $this->request->getVar('nameCategorieU');
            $nombreBouteille = $this->request->getVar('nombreBouteilleU');
            $data = $model->getCategorieById($idCategorie);

            if (sizeof($data) == 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    'msg'     => "cette categorie n'existe pas",
                ];
                return $this->respond($response);
            }else{ 
    
                $data = [
                    'nameCategorie'     => $nameCategorie,
                    'nombreBouteille'     => $nombreBouteille,
                    'updated_at'        => date("Y-m-d H:m:s")
                ];
                if ($model->where('idCategorie', $idCategorie)->set($data)->update() === false) {
                    $response = [
                        "success" => false,
                            "status"  => 500,
                            "code"    => "error",
                            "title"   => "Erreur",
                            'msg'     => "Echec de modification",
                        ];
                    
                        return $this->respond($response);
                }else{
                    $neWCategorie = $model->getCategorieById($idCategorie);
                    $response = [
                        "success" => true,
                        "status"  => 200,
                        "code"    => "Success",
                        "title"   => "Réussite",
                        'msg'     => "Modification réussie",
                        'data'    => $neWCategorie[0]
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
                'msg'     => "Echec de modification de la categorie",
                "error" => $this->validator->getErrors(), 
            ];

            return $this->respond($response);
        }
        
    }
}
