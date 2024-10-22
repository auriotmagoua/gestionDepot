<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index'); 

$routes->group('view', static function($routes){
    $routes->get('HomePage', 'Home::homePage');
    $routes->get('Vente_produit', 'Home::vente_produit');
    $routes->get('Historique_vente', 'Home::historique_vente');
    $routes->get('Save_produit', 'Home::save_produit');
    $routes->get('Save_fournisseur', 'Home::save_fournisseur');
    $routes->get('Save_user', 'Home::save_user');
    $routes->get('Save_client', 'Home::save_client');
    $routes->get('Save_entree', 'Home::save_entree');
    $routes->get('Save_categorie', 'Home::save_categorie');
    $routes->get('List_payement', 'Home::list_payement');
    $routes->get('Solde_client', 'Home::solde_client');
    $routes->get('Emprunt_produit', 'Home::emprunt_produit');
    $routes->get('List_approvisionnement', 'Home::List_approvisionnement');
});

$routes->group('user', static function($routes){
    $routes->post('login', 'AuthentificationController::authentification');
    $routes->get('LogOut', 'AuthentificationController::logOut');
    $routes->get('Change_password', 'Home::change_password');
    $routes->post('Save_user', 'UserController::save');
    $routes->get('List_user', 'UserController::list');
    $routes->get('Delete/(:any)', 'UserController::deleteUser/$1');
    $routes->post('Reinitialiser_password/(:any)', 'UserController::reinitialiserPassword/$1');
    $routes->post('Change_pass/(:any)', 'UserController::change_password/$1');

});

$routes->group('client', static function($routes){
    $routes->post('Save_client', 'ClientController::save');
    $routes->get('List_client', 'ClientController::list');
    $routes->get('Delete/(:any)', 'ClientController::deleteClient/$1');
    $routes->post('Update', 'ClientController::updateClient');
    $routes->get('getOneClient/(:any)', 'ClientController::getOne/$1');
    $routes->get('Solde_client/(:any)', 'AcheterController::solde_client/$1');
});

$routes->group('produit', static function($routes){
    $routes->post('Save_produit', 'ProduitController::save');
    $routes->get('List_produit', 'ProduitController::list');
    $routes->get('delete/(:any)', 'ProduitController::deleteProduit/$1');
    $routes->post('update', 'ProduitController::updateProduit');
    $routes->get('historique_vente/(:any)', 'AcheterController::getHistoriqueVente/$1');
    // $routes->get('getFactureDistinct', 'AcheterController::getFactureDistinct');
    $routes->get('annuler/(:any)', 'AcheterController::annulerFacture/$1');
    $routes->get('getAllNumFact', 'AcheterController::getAllNumFact');
    $routes->post('vente/(:any)', 'AcheterController::vente/$1');
    $routes->post('vente_revendeur/(:any)', 'AcheterController::vente_revendeur/$1');
    $routes->get('getOneProduit/(:any)', 'ProduitController::getOne/$1');
    $routes->get('numberProduit', 'ProduitController::numbreProduit');
    $routes->get('StatistiqueVente', 'AcheterController::StatistiqueVente');
});
// $routes->group('payement', static function($routes){
//     $routes->get('ListPayementFact/(:any)', 'PayementController::listPayementFact/$1');
//     $routes->get('List_payement', 'PayementController::list');
//     $routes->get('annuler/(:any)', 'PayementController::annulerPayement/$1');
//     $routes->get('List_payement_client', 'PayementController::listPayementClient');
//     $routes->post('Save_versement/(:any)', 'PayementController::saveVersement/$1');
// });
$routes->group('fournisseur', static function($routes){
    $routes->post('Save_fournisseur', 'FournisseurController::save');
    $routes->get('List_fournisseur', 'FournisseurController::list');
    $routes->get('Delete/(:any)', 'FournisseurController::deleteFournisseur/$1');
    $routes->post('Update', 'FournisseurController::updateFournisseur');
    $routes->get('getOneFournisseur/(:any)', 'FournisseurController::getOne/$1');
});

$routes->group('categorie', static function($routes){
    $routes->post('Save_categorie', 'CategorieController::save');
    $routes->get('List_categorie', 'CategorieController::list');
    $routes->get('Delete/(:any)', 'CategorieController::deleteCategorie/$1');
    $routes->get('getOneCategorie/(:any)', 'CategorieController::getOne/$1');
    $routes->post('Update', 'CategorieController::updateCategorie');
});
$routes->group('entree', static function($routes){
    $routes->post('Save_entree', 'EntreeController::save');
    // $routes->get('List_categorie', 'CategorieController::list');
    // $routes->get('Delete/(:any)', 'CategorieController::deleteCategorie/$1');
    // $routes->get('getOneCategorie/(:any)', 'CategorieController::getOne/$1');
    // $routes->post('Update', 'CategorieController::updateCategorie');
});



