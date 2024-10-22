<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FournisseurModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\History;

include('History/HistorySession.php');

class FournisseurController extends ResourcePresenter
{
    use ResponseTrait;

    //save client
    public function save(){
        $rules = [
            'nameFournisseur'  => 'required',
            'phoneFournisseur' => 'required|trim|is_unique[fournisseur.phoneFournisseur]',
        ];

        if ($this->validate($rules)) {
            $model = new FournisseurModel();

            $name      = $this->request->getVar('nameFournisseur');
            $phone     = $this->request->getVar('phoneFournisseur');

                // session
                $HistorySession = new HistorySession();
                $data_session = $HistorySession->getInfoSession();
                $idUser = $data_session['idUser'];

            $data_fournis = $model->getFournisseurByNamePhone($name,$phone);
            
            if (sizeof($data_fournis) != 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'L\'e fournisseur existe déjà',
                ];
                return $this->respond($response);
            }else {
            
                $data = [
                    'nameFournisseur' => $this->request->getVar('nameFournisseur'),
                    'phoneFournisseur' => $this->request->getVar('phoneFournisseur'),
                    'idUser' => $idUser,
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
                    "msg"     => "Fournisseur enregistré avec succès"
                ];
                return $this->respond($response);
            }
        }else {
            $response = [
                "success" => false,
                "status" => 400,
                "code" => "error",
                "title" => "Erreur de validation",
                "error" => $this->validator->getErrors(), 
                "msg" => "Erreur de validation", 
            ];
            
            return $this->respond($response);
        }
    }

    //list de tout les clients
    public function list(){
        $FournisseurModel = new FournisseurModel();

        $data = $FournisseurModel->getAllFournisseur();

        return $this->respond($data);
    }

    // supprimer un Fournisseur 
    public function deleteFournisseur($idFournis){

        $FournisseurModel = new FournisseurModel(); 
        $data = $FournisseurModel->getFournisseurById($idFournis);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Ce fournisseur  n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($FournisseurModel->where('idFournisseur', $idFournis)->set($data)->update() === false) {
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

    // modifier un Fournisseur
    public function updateFournisseur(){

        $rules = [
            'nameFournisseurU'       => 'required',
            'phoneFournisseurU'      => 'required|min_length[9]|trim',
            'idFournisseurU'         => 'required'

        ];

        if ($this->validate($rules)) {
            $FournisseurModel = new FournisseurModel(); 

            $nameFournisseur = $this->request->getVar('nameFournisseurU');
            $phoneFournisseur  = $this->request->getVar('phoneFournisseurU');
            $idFournis  = $this->request->getVar('idFournisseurU');
            
            $data_fournis = $FournisseurModel->getFournisseurById($idFournis);

            if (sizeof($data_fournis) == 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    'msg'     => "Ce fournisseur n'existe pas",
                ];
                return $this->respond($response);
            }else{ 
    
                $data = [
                    'nameFournisseur'   => $nameFournisseur ,
                    'phoneFournisseur'     => $phoneFournisseur,
                    'idFournisseur'     => $idFournis,
                    'updated_at'        => date("Y-m-d H:m:s")
                ];
                if ($FournisseurModel->where('idFournisseur', $idFournis)->set($data)->update() === false) {
                    $response = [
                        "success" => false,
                            "status"  => 500,
                            "code"    => "error",
                            "title"   => "Erreur",
                            'msg'     => "Echec de modification",
                        ];
                    
                        return $this->respond($response);
                }else{
                    $neWFournisseur = $FournisseurModel->getFournisseurById($idFournis);
                    $response = [
                        "success" => true,
                        "status"  => 200,
                        "code"    => "Success",
                        "title"   => "Réussite",
                        'msg'     => "Modification réussie",
                        'data'    => $neWFournisseur[0]
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
                'msg'     => "Echec de modification de du client",
            ];

            return $this->respond($response);
        }
        
    }

    // recuperer un seul Fournisseur
    public function getOne($idFournis){
        $FournisseurModel = new FournisseurModel(); 
        $data = $FournisseurModel->getFournisseurById($idFournis);
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
}
