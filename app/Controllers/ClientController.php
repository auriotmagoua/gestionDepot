<?php

namespace App\Controllers;

// use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\ClientModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\History;
include('History/HistorySession.php');


class ClientController extends ResourcePresenter
{
    use ResponseTrait;

    //save client
    public function save(){
        $rules = [
            'nameClient'  => 'required',
            'phoneClient' => 'required|trim|is_unique[client.phoneClient]',
        ];

        if ($this->validate($rules)) {
            $model = new ClientModel();

            $name      = $this->request->getVar('nameClient');
            $phone     = $this->request->getVar('phoneClient');

                // session
                $HistorySession = new HistorySession();
                $data_session = $HistorySession->getInfoSession();
                $idUser = $data_session['idUser'];

            $data_client = $model->getClient($name,$phone);
            
            if (sizeof($data_client) != 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'L\'e client existe déjà',
                ];
                return $this->respond($response);
            }else {
            
                $data = [
                    'nameClient' => $this->request->getVar('nameClient'),
                    'phoneClient' => $this->request->getVar('phoneClient'),
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
                    "msg"     => "Client enregistré avec succès"
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
        $ClientModel = new ClientModel();

        $data = $ClientModel->getAllClient();

        return $this->respond($data);
    }

    // supprimer un client 
    public function deleteClient($idClient){

        $ClientModel = new ClientModel(); 
        $data = $ClientModel->getClientById($idClient);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Ce client  n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($ClientModel->where('idClient', $idClient)->set($data)->update() === false) {
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

    // modifier un client
    public function updateClient(){

        $rules = [
            'nameClientU'       => 'required',
            'phoneClientU'      => 'required|min_length[9]|trim',
            'idClientU'         => 'required'

        ];

        if ($this->validate($rules)) {
            $ClientModel = new ClientModel(); 

            $nameClient = $this->request->getVar('nameClientU');
            $phoneClient = $this->request->getVar('phoneClientU');
            $idClient = $this->request->getVar('idClientU');
            
            $data_client = $ClientModel->getClientById($idClient);

            if (sizeof($data_client) == 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    'msg'     => "ce client n'existe pas",
                ];
                return $this->respond($response);
            }else{ 
    
                $data = [
                    'nameClient'   => $nameClient ,
                    'phoneClient'     => $phoneClient,
                    'idClient'     => $idClient,
                    'updated_at'        => date("Y-m-d H:m:s")
                ];
                if ($ClientModel->where('idClient', $idClient)->set($data)->update() === false) {
                    $response = [
                        "success" => false,
                            "status"  => 500,
                            "code"    => "error",
                            "title"   => "Erreur",
                            'msg'     => "Echec de modification",
                        ];
                    
                        return $this->respond($response);
                }else{
                    $neWClient = $ClientModel->getClientById($idClient);
                    $response = [
                        "success" => true,
                        "status"  => 200,
                        "code"    => "Success",
                        "title"   => "Réussite",
                        'msg'     => "Modification réussie",
                        'data'    => $neWClient[0]
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
                'msg'     => "Echec de modification  du client",
            ];

            return $this->respond($response);
        }
        
    }

    // recuperer les infos d'un  seul client
    public function getOne($idClient){
        $ClientModel = new ClientModel(); 
        $data = $ClientModel->getClientById($idClient);
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
