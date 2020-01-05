<?php

include_once 'models/userModel.php';
include_once 'libs/user.php';

class Registro extends Controller {

    function __construct() {
        parent::__construct();
    }

    function render() {

        if (isset($_POST['cedula'])) {

            $user = new UserModel($_POST['cedula'],
                            $_POST['nombre'],
                            $_POST['apellido1'],
                            $_POST['apellido2'],
                            $_POST['correo'],
                            password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
                            $_POST['telefono']);

            $userDatabase = new User();
            $result = $userDatabase->insertUser($user);

            if ($result) {
                $this->view->message = 'Usuario ingresado correctamente';
                $this->view->render('registro/registro');
            }
            else {
                $this->view->message = 'Error al ingresar el usuario';
                $this->view->render('registro/registro');
            }

        }
        else {
            $this->view->render('registro/registro');
        }
    }
}

?>