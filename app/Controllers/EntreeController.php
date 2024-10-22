<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use App\Models\EntreeModel;
use App\Controllers\History;
include('History/HistorySession.php');

class EntreeController extends ResourcePresenter
{
    use ResponseTrait;
    // public function list(){
    //     $CategorieModel = new CategorieModel();

    //     $data = $CategorieModel->getAllCategorie();

    //     return $this->respond($data);
    // }

    public function save(){
        $rules = [
            'idProduit'      => 'required',
            'nombreCasier'   => 'required'
        ];

        if ($this->validate($rules)) {
            $model = new EntreeModel();

            $idProduit       = $this->request->getVar('idProduit');
            $nombreCasier    = $this->request->getVar('nombreCasier');


            // session
            $HistorySession = new HistorySession();
            $data_session = $HistorySession->getInfoSession();
            $idUser = $data_session['idUser'];
            $data = $model->getNombreBoutProdById($idProduit);
            if (sizeof($data) != 0 ) {
                $nombre_bouteille = $data[0]['nombreBouteille'] * $nombreCasier;
                var_dump($nombre_bouteille );
                // $data = [
                //     'nameCategorie'    => $nameCategorie,
                //     'nombreBouteille'  => $nombreBouteille,
                //     'idUser'       => $idUser, 
                //     'created_at'   => date("Y-m-d H:i:s"),
                //     'is_enable'    => true,
                //     'is_delete'    => false,
                // ];
                // $model->save($data);
                // $response = [
                //     "success" => true,
                //     "status"  => 200,
                //     "code"    => "success",
                //     "title"   => "Réussite",
                //     "autorisation"   => true,
                //     "msg"     => "Categorie enregistré avec succès"
                // ];
                // return $this->respond($response);
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

}
