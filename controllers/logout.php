<?php

include_once 'libs/user_session.php';

class Logout extends Controller{
    public $userSession;

    function __construct(){
        parent::__construct(); 
    }

    function render(){
        $userSession = new UserSession();
        $userSession->closeSession();
        $this->view->render('index/index');
        //header("location: ../index.php");
    }
}


?>