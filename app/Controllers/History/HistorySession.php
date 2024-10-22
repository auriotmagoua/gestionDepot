<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HistorySession extends BaseController
{
    public function getInfoSession(){
        // session
        $session = session();

        $data = [
            "idUser"    => $session->get('idUser'),
            "typeUser"  => $session->get('typeUser'),
            "login"     => $session->get('login'),
            "password"  => $session->get('password'),
        ];
        return $data;
    }
    
}   