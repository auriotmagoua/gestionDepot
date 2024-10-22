<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Controllers\History;

include('History/HistorySession.php');

class UserController extends ResourcePresenter
{
    use ResponseTrait;


    //save user
    public function save(){
        $rules = [
            'login2'         => 'required',
            'password2'      => 'required|min_length[6]|trim',
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();

            $loginUser  = $this->request->getVar('login2');
            $passwd     = $this->request->getVar('password2');

            if($loginUser == 'user' || $loginUser == 'USER'){
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'Impossible d\'utiliser le login: user'
                ];
                return $this->respond($response);
            }

            // session
            $HistorySession = new HistorySession();
            $data_session = $HistorySession->getInfoSession();
            $idUser = $data_session['idUser'];

            $data_user = $model->getUser($loginUser, md5($passwd));
            
            if (sizeof($data_user) != 0) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => 'L\'utilisateur existe déjà',
                ];
                return $this->respond($response);
            }else {
            
                $data = [
                    'login' => $this->request->getVar('login2'),
                    'password' => md5($this->request->getVar('password2')),
                    'typeUser' => 'user', 
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
                    "msg"     => "Utilisateur enregistrer avec success"
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

    //list de tout les utilisateurs
    public function list(){
        $UserModel = new UserModel();

        $data = $UserModel->getAllUser();

        return $this->respond($data);
    }


    public function deleteUser($idUser){

        $UserModel = new UserModel(); 
        $data = $UserModel->getUserById($idUser);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Cette Utilisateur  n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($UserModel->where('idUser', $idUser)->set($data)->update() === false) {
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
                    'msg'     => "Suppression reussir",
                ];
                return $this->respond($response);
            
            }   
                    
        }
    }


    public function reinitialiserPassword($idUser){

        $UserModel = new UserModel(); 
        $data = $UserModel->getUserById($idUser);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Cet Utilisateur n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
            $pass_reset = 'user'.$data[0]["idUser"].'23';
            $data = [
                'login'        => ('user'),
                'password'     => md5($pass_reset),
            ];
            if ($UserModel->where('idUser', $idUser)->set($data)->update() === false) {
                  $response = [
                        "success" => false,
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        'msg'     => "Echec de reinitialisation",
                    ];
                  
                    return $this->respond($response);
            }else{
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "Success",
                    "title"   => "Réussite",
                    'msg'     => "Réinitialisation réussie",
                    'data'    => "Identifiants: Login= user & Password= ".$pass_reset,
                ];
                return $this->respond($response);
            
            }   
                    
        }
    }

    public function change_password($idUser){

        $UserModel = new UserModel(); 
        $data_user = $UserModel->getUserById($idUser);

        if($this->request->getVar('login2') == 'user' || $this->request->getVar('login2') == 'USER'){
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                "msg"     => 'Impossible d\'utiliser le login: user'
            ];
            return $this->respond($response);
        }

        if (sizeof($data_user) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Cette Utilisateur  n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $hashedPassword =$data_user[0]['password'];
            $data = [
                'login'      => $this->request->getVar('login2'),
                'password'     => md5($this->request->getVar('passwd2')),
            ];
            
            if((md5($this->request->getVar('passwd1')) != $hashedPassword)){

                $response = [
                    "success" => false,
                      "status"  => 500,
                      "code"    => "error",
                      "title"   => "Erreur",
                      'msg'     => "L'ancien mot de passe ne correspond pas",
                ];
                return $this->respond($response);
            }else if ($UserModel->where('idUser', $idUser)->set($data)->update() === false) {
                $response = [
                    "success" => false,
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    'msg'     => "Echec de Changement d'information",
                ];
                
                return $this->respond($response);
            }else{
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "Success",
                    "title"   => "Réussite",
                    'msg'     => "Changement  reussi",
                ];
                return $this->respond($response);
            
            }   
                    
        }
    }
}