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

        //verifica si hay usuario en sesión y si es así retorna su información en un objeto user.
        if(isset($_SESSION['user'])){
            $user->setUser($userSession->getCurrentEmail());
            $this->view->user = $user;
            $this->view->render('inicio/index');

        // Si fueron insertados un email y una contrasena por el usuario.
        }else if(isset($_POST['correo']) && isset($_POST['contrasena'])){
            $emailForm = $_POST['correo'];
            $passForm = $_POST['contrasena'];
            $user = new User();
            
            //se verifica la existencia de la información suministrada.
            if($user->userExists($emailForm, $passForm)){
                $userSession->setCurrentEmail($emailForm);
                $user->setUser($emailForm);
                $userSession->setCurrentNombre($user->getNombre());
                $userSession->setCurrentPosicion($user->getPosicion());
                $userSession->setCurrentCedula($user->getCedula());
                $userSession->setCurrentDepartamento($user->getDepartamento());
                $userSession->setAdministrador($user->getAdministrador());
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