<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use \Firebase\JWT\JWT;
use App\Controllers\History;

include('History/HistorySession.php');

class AuthentificationController extends ResourcePresenter
{
    use ResponseTrait;

    public function __construct()
    {
        $this->UserModel = new UserModel();
    }
    
    public function password_verify($pass1, $pass2){
        if ($pass1 == $pass2) {
            return true;
        }else if ($pass1 != $pass2) {
            return false;
        }
    }

    public function authentification()
    {
        $UserModel          = new UserModel();
        $HistorySession     = new HistorySession();
        $session            = session();
       
        $rules = [
            'login'        => 'required|min_length[3]|trim' ,
            'password'     => 'required|min_length[3]|trim'
        ];

        //'file' => 'uploaded[file]|max_size[file,1024]|mime_in[file,text/csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
        if ($this->validate($rules)) {
            $login = $this->request->getvar('login');
            $password = $this->request->getvar('password');

            if ($login == NULL || $password == NULL) {
                $response = [
                    "success" => false,
                    'motif'   => 'error',
                    "status"  => 500,
                    "code"    => "error",
                    "title"   => "Erreur",
                    "msg"     => "le login ou mot de passe est obigatoire",
                ];
                return $this->respond($response);
            }else{
                $user = $UserModel->where('login', strtolower($login))->first();
                
                if(is_null($user)) {
                    $response = [
                        "success" => false,
                        'motif'   => 'error',
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        "msg"     => "Login ou mot de passe incorrecte ",
                    ];
                    return $this->respond($response);
                }

                $pwd_verify = $this->password_verify(md5($password), $user['password']);
                if(!$pwd_verify) {
                    $response = [
                        "success" => false,
                        'motif'   => 'error',
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        "msg"     => "Login ou mot de passe incorrecte",
                    ];
                    return $this->respond($response);
                }

                // prepare a token jwt
                $key = getenv('JWT_SECRET');
                $iat = time(); // current timestamp value
                $exp = $iat + 360000;

                $payload = array(
                    "iss" => "Issuer of the JWT",
                    "aud" => "Audience that the JWT",
                    "sub" => "Subject of the JWT",
                    "iat" => $iat, //Time the JWT issued at
                    "exp" => $exp, // Expiration time of token
                    "email" => $user['login'],
                );

                $token = JWT::encode($payload, $key, 'HS256');

                // $session->setExpiration(getenv('session.expiration'));
                $session->set('idUser', $user['idUser']);
                $session->set('login', $user['login']);
                $session->set('typeUser', $user['typeUser']);
                // $session->sets('type_trainee', $user['trainee_type']);
                $session->set('autorisation', true);
                $session->set('token', $token);
                $session->set('password', $user['password']);

                $response = [
                    "success"      => true,
                    "status"       => 200,
                    "code"         => "success",
                    "title"        => "Réussite",
                    "autorisation" => true,
                    "msg"          => "Connexion Réussir",
                    "data"         => [
                        "idUser"   => $user['idUser'],
                        "login"    => $user['login'],
                        "typeUser" => $user['typeUser'],
                        "token"    => $token
                    ]
                ];
                return $this->respond($response);
            }

        }else{
            //validation failed
            $response = [
                "success" => false,
                'motif'   => 'error',
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                "msg"     => "Erreur de validation",
                "error"   => $this->validator->getErrors(),
            ];
            return $this->respond($response);
        }
    }

    public function logOut(){
        $session = session();
        $session->destroy();

        return view("login");
    }
}
