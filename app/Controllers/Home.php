<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }
    public function homePage()
    {
        return view('pages/acceuil/homePage');
    }
    public function Vente_produit(){
        return view('pages/produit/vente_produit');
    }
    public function Historique_vente(){
        return view('pages/produit/historique_vente');
    }
    public function Save_produit(){
        return view('pages/produit/save_produit');
    }
    public function Save_client(){
        return view('pages/client/save_client');
    }
    public function Solde_client(){
        return view('pages/client/solde_client');
    }
    public function List_payement(){
        return view('pages/payement/list_payement');
    }
    public function Change_password(){
        return view('pages/user/change_password');
    }
    public function Save_user(){
        return view('pages/user/save_user');
    }
    public function Emprunt_produit(){
        return view('pages/produit/save_emprunt');
    }
    public function List_approvisionnement(){
        return view('pages/produit/save_entree');
    }
    public function Save_fournisseur(){
        return view('pages/fournisseur/save_fournisseur');
    }
    public function Save_entree(){
        return view('pages/entree/save_entree');
    }
    public function Save_categorie(){
        return view('pages/categorie/save_categorie');
    }
}

