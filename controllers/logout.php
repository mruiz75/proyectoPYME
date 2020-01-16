<?php

/**
 * Clase usada para desconectar al usuario de la sesión y terminarla.
 */

include_once 'libs/user_session.php';

class Logout extends Controller{
    public $userSession;

    function __construct(){
        parent::__construct(); 
    }

    function render(){
        $userSession = new UserSession();
        $userSession->closeSession();
        header('location:'.constant('URL').'index');
    }
}


?>