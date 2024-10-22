<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;
use App\Models\AcheterModel;
use App\Models\PayementModel;
use App\Models\ProduitModel;
use App\Models\ClientModel;
use App\Controllers\History;

include('History/HistorySession.php');

class AcheterController extends ResourcePresenter
{

    use ResponseTrait;

    function StatistiqueVente(){
        $model = new AcheterModel();
        $date = date("Y-m-d");

        $allVente = $model->getAllAchatDay($date);
        $total = 0;
        foreach ($allVente as $vente) {
            $total += $vente["quantite"] * $vente["prix"];
        }

        $data_final = [
            "totalVente"  => $total,
        ];
        return $this->respond($data_final);
    }


    //enregistrer une vente
    public function vente($idUser) {
        $rules = [
            'nameC'           => 'required',
            'phoneC'          => 'required',
            'name'            => 'required', // Assurez-vous que c'est un tableau
            'prix'            => 'required',
            'mode_paiement'   => 'required',
            'qte'             => 'required'
        ];
    
        if ($this->validate($rules)) {
            $AcheterModel = new AcheterModel();
    
            $nameC      = $this->request->getVar('nameC');
            $phoneC     = $this->request->getVar('phoneC');
            $remise     = $this->request->getVar('remise');
            $name       = $this->request->getVar('name');
            $mode       = $this->request->getVar('mode_paiement');
            $prix       = $this->request->getVar('prix');
            $quantite   = $this->request->getVar('qte');
            $numAchat   = $AcheterModel->generateNumAchat();
    
            // Vérifiez si des valeurs vides existent dans le tableau `name`, `prix` et `quantite`
            foreach ($name as $index => $produit) {
                if (empty($produit)) {
                    $response = [
                        "success" => false,
                        "status"  => 400,
                        "code"    => "error",
                        "title"   => "Erreur de validation",
                        "msg" => "Veuillez choisir un produit à la ligne : '" . ($index + 1) . "'.", 
                    ];
                    return $this->respond($response);
                }
    
                // Vérification du prix
                if (empty($prix[$index])) {
                    $response = [
                        "success" => false,
                        "status"  => 400,
                        "code"    => "error",
                        "title"   => "Erreur de validation",
                        "msg" => "Veuillez renseigner un prix à la ligne : '" . ($index + 1) . "'.", 
                    ];
                    return $this->respond($response);
                }
    
                // Vérification de la quantité
                if (empty($quantite[$index])) {
                    $response = [
                        "success" => false,
                        "status"  => 400,
                        "code"    => "error",
                        "title"   => "Erreur de validation",
                        "msg" => "Veuillez renseigner une quantité à la ligne : '" . ($index + 1) . "'.", 
                    ];
                    return $this->respond($response);
                }
            }
    
            foreach ($name as $index => $produit) {
                $data = [
                    'nameAcheter' => $nameC,
                    'phone'       => $phoneC,
                    'idProduit'   => $name[$index],
                    'idUser'      => $idUser,
                    'prix'        => $prix[$index],
                    'remise'      => $remise,
                    'mode'        => $mode,
                    'quantite'    => $quantite[$index],
                    'numAcheter'  => $numAchat,
                    'created_at'  => date("Y-m-d H:i:s"),
                    'is_enable'   => true,
                    'is_delete'   => false
                ];
    
                if (!$AcheterModel->save($data)) {
                    $response = [
                        "success" => false,
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        "msg"     => "Échec de la Vente des produits",
                    ];
                    return $this->respond($response);
                }
            }
    
            $PayementModel = new PayementModel();
            $data = [
                'numAcheter' => $numAchat,
                'idUser'     => $idUser,
                'avance'    => $this->request->getVar('netAPayer'),
                'remise'    => $this->request->getVar('remise'),
                'created_at' => date("Y-m-d H:i:s"),
                'is_enable'  => true,
                'is_delete'  => false,
            ];
            if ($PayementModel->save($data)) {
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "success",
                    "title"   => "Réussite",
                    "msg"     => "Vente effectuée avec succès"
                ];
                return $this->respond($response);
            }
    
        } else {
            // Erreur de validation
            $response = [
                "success" => false,
                "status"  => 400,
                "code"    => "error",
                "title"   => "Erreur de validation",
                "error"   => $this->validator->getErrors(),
                "msg"     => "Veuillez renseigner tous les champs obligatoires", 
            ];
            return $this->respond($response);
        }
    }

    //enregistrer une vente des clients revendeur
    public function vente_revendeur($idUser) {

        $rules = [
            'idClient'        => 'required',
            'name'            => 'required',
            'prix'            => 'required',
            'mode_paiement'   => 'required',
            'qte'             => 'required'
        ];
    
        if ($this->validate($rules)) {
            $AcheterModel = new AcheterModel();

            $ClientModel = new ClientModel();

            $data_client = $ClientModel->getClientById($this->request->getVar('idClient'));
            
            if(sizeof($data_client) != 0){

                $avance     = $this->request->getVar('avance');
                $idClient   = $this->request->getVar('idClient');
                $remise     = $this->request->getVar('remise');
                $name       = $this->request->getVar('name');
                $mode       = $this->request->getVar('mode_paiement');
                $prix       = $this->request->getVar('prix');
                $quantite   = $this->request->getVar('qte');
                $numAchat   = $AcheterModel->generateNumAchat();

                if(empty($idClient)){
                    $response = [
                        "success" => false,
                        "status"  => 400,
                        "code"    => "error",
                        "title"   => "Erreur de validation",
                        "msg" => "Veuillez choisir un client", 
                    ];
                    return $this->respond($response);
                }
                foreach ($name as $index => $produit) {
                    if (empty($produit)) {
                        $response = [
                            "success" => false,
                            "status"  => 400,
                            "code"    => "error",
                            "title"   => "Erreur de validation",
                            "msg" => "Veuillez choisir un produit à la ligne : '" . ($index + 1) . "'.", 
                        ];
                        return $this->respond($response);
                    }
        
                    // Vérification du prix
                    if (empty($prix[$index])) {
                        $response = [
                            "success" => false,
                            "status"  => 400,
                            "code"    => "error",
                            "title"   => "Erreur de validation",
                            "msg" => "Veuillez renseigner un prix à la ligne : '" . ($index + 1) . "'.", 
                        ];
                        return $this->respond($response);
                    }
        
                    // Vérification de la quantité
                    if (empty($quantite[$index])) {
                        $response = [
                            "success" => false,
                            "status"  => 400,
                            "code"    => "error",
                            "title"   => "Erreur de validation",
                            "msg" => "Veuillez renseigner une quantité à la ligne : '" . ($index + 1) . "'.", 
                        ];
                        return $this->respond($response);
                    }
                }

                foreach ($name as $index => $produit) {
                    $data = [
                        'idClient'      => $idClient,
                        'nameAcheter'   => $data_client[0]['nameClient'],
                        'phone'         => $data_client[0]['phoneClient'],
                        'remise'        => $remise,   
                        'idProduit'     => $name[$index],   
                        'idUser'        => $idUser,
                        'prix'          => $prix[$index],   
                        'quantite'      => $quantite[$index],
                        'numAcheter'    => $numAchat,
                        'created_at'    => date("Y-m-d H:i:s"),
                        'is_enable'     => true,
                        'is_delete'     => false
                    ];
                    if (!$AcheterModel->save($data)) {
                        $response = [
                            "success" => false,
                            "status"  => 500,
                            "code"    => "error",
                            "title"   => "Erreur",
                            "msg"     => "Échec de la Vente des produits",
                        ];
                        return $this->respond($response);
                    }    
                }       
                
                if($avance){
                    $PayementModel = new PayementModel();
                    $data = [
                        'numAcheter' => $numAchat,
                        'idUser'     => $idUser,
                        'idClient'   => $idClient,
                        'avance'     => $avance,
                        'remise'     => $remise,
                        'mode'       => $mode,
                        'created_at' => date("Y-m-d H:i:s"),
                        'is_enable'  => true,
                        'is_delete'  => false,
                    ];
                    $PayementModel->save($data);
                    $response = [
                        "success" => true,
                        "status"  => 200,
                        "code"    => "success",
                        "title"   => "Réussite",
                        "msg"     => "payement effectué avec succès"
                    ];
                    return $this->respond($response);
                }
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "success",
                    "title"   => "Réussite",
                    "msg"     => "Vente effectué avec succès"
                ];
                return $this->respond($response);

            }
    
        } else {
            $response = [
                "success" => false,
                "status"  => 400,
                "code"    => "error",
                "title"   => "Erreur de validation",
                "error"   => $this->validator->getErrors(), 
                "msg"     => "Veuillez renseigner tous les champs obligatoire", 
            ];
            return $this->respond($response);
        }
    }

    // lhistorique de tout les vente et ou en fonction du numero de facture
    // function getHistoriqueVente($numAchat){
    //     $AcheterModel = new AcheterModel();
    //     $PayementModel = new PayementModel();
    //     $ProduitModel = new ProduitModel();
    //     $data_acheter = array();
    //     if ($numAchat == 0) {
    //         $data_acheter = $AcheterModel->getAllVente();
    //     }else{
    //         $data_acheter = $AcheterModel->getOneVente($numAchat);
    //     }
        
    //     $data = array();

    //     foreach ($data_acheter as $row) {
    //         $data[] = [
    //             "nameAcheter"   => $row["nameAcheter"],
    //             "phone"         => $row["phone"],
    //             "prix"          => $row["prix"],
    //             "quantite"      => $row["quantite"],
    //             "numAcheter"    => $row["numAcheter"],
    //             "nameProduit"   => $row["nameProduit"],
    //             "created_at"    => $row["created_at"]
    //         ];

    //     }

    //     return $this->respond($data);
    // }

    // lhistorique de tout les vente et ou en fonction du numero de facture
    function getHistoriqueVente($numAchat){
        $model = new AcheterModel();
        $data_final = array();

        if ($numAchat == 0) {
            $allFact = $model->getDistinctAllFact();
        }else{
            $allFact = $model->getDistinctOneFact($numAchat);
        }

        foreach ($allFact as $facture) {
            $products = $model->getAllProduitFact($facture["numAcheter"]);
            $chaine_product = "";
            
            foreach ($products as $product) {
                $chaine_product .= $product["nameProduit"]." : ".$product["quantite"]." X ".$product["prix"].",";
            }

            $data_final[] = [
                "nameAcheter"  => $facture["nameAcheter"],
                "phone"        => $facture["phone"],
                "numAcheter"   => $facture["numAcheter"],
                "nameProduit"  => $chaine_product,
                "created_at"   => $facture["created_at"]
            ];
        }
        return $this->respond($data_final);
    }

    // recuperer tout les numero de facture
    function getAllNumFact(){
        $AcheterModel = new AcheterModel();
        $data = $AcheterModel->getAllNumFact();
        return $this->respond($data);
    }
    
    // annuler une vente
     function annulerFacture($numAchat){

        $AcheterModel = new AcheterModel(); 
        $data = $AcheterModel->getVenteByNumFact($numAchat);

        if (sizeof($data) == 0) {
            $response = [
                "success" => false,
                "status"  => 500,
                "code"    => "error",
                "title"   => "Erreur",
                'msg'     => "Cette facture n'existe pas",
            ];
            return $this->respond($response);
        }else{ 
  
            $data = [
                'is_delete'        => true,
                'deleted_at'       => date("Y-m-d H:m:s"),
            ];
            if ($AcheterModel->where('numAcheter', $numAchat)->set($data)->update() === false) {
                  $response = [
                      "success" => false,
                        "status"  => 500,
                        "code"    => "error",
                        "title"   => "Erreur",
                        'msg'     => "Echec de l'annulation",
                    ];
                  
                    return $this->respond($response);
            }else{
                $response = [
                    "success" => true,
                    "status"  => 200,
                    "code"    => "Success",
                    "title"   => "Réussite",
                    'msg'     => "Annulation reussir",
                ];
                return $this->respond($response);
            
            }   
                    
        }
    }


    function solde_client($idClient){
        $ClientModel = new ClientModel();

        $data_client = $ClientModel->getClientById($idClient);

        $response["idClient"] = $idClient;
        $response["nameClient"] = $data_client[0]["nameClient"];
        return view('pages/client/solde_client', $response);
    }
}

