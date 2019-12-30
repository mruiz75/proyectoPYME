<?php

include_once 'libs/user.php';
include_once 'libs/user_session.php';


class Index extends Controller{

    public $userSession;
    public $user;

    function __construct(){
        parent::__construct();
    }
    // function render(){
    //     $this->view->render('index/index');
    // }

    function render(){

        $userSession = new UserSession();
        $user = new User();

        if(isset($_SESSION['user'])){
            $user->setUser($userSession->getCurrentEmail());
            $this->view->user = $user;
            $this->view->render('inicio/index');

        }else if(isset($_POST['correo']) && isset($_POST['contrasena'])){
            $emailForm = $_POST['correo'];
            $passForm = $_POST['contrasena'];
            $user = new User();
            
            if($user->userExists($emailForm, $passForm)){
                $userSession->setCurrentEmail($emailForm);
                $user->setUser($emailForm);
                $userSession->setCurrentNombre($user->getNombre());
                $userSession->setCurrentPosicion($user->getPosicion());
                $userSession->setCurrentCedula($user->getCedula());
                $this->view->user = $user;
                $this->view->render('inicio/index');
            
            }else{
                $errorLogin = "Nombre de usuario y/o password incorrecto";
                $this->view->errorLogin = $errorLogin;
                $this->view->render('index/index');
            }

        }else{
            $this->view->render('index/index');
        }
    }

}

?>