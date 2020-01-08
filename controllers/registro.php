<?php

include_once 'models/userModel.php';
include_once 'libs/user.php';

/**
 * Class Registro
 * Controller para el registro de un usuario
 */
class Registro extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion principal del controller que muestra la vista
     * o llama al modelo para registrar el usuario en la base
     */
    function render() {

        if (isset($_POST['cedula'])) {

            $idDepartamento = $this->model->getDepartamentoId($_POST['departamento']);

            $nivel = 0;
            switch ($_POST['nivel']) {
                case "Manager":
                    $nivel = 1;
                    break;
                case "Empleado":
                    $nivel = 2;
                    break;
            }

            $user = new UserModel($_POST['cedula'],
                            $_POST['nombre'],
                            $_POST['apellido1'],
                            $_POST['apellido2'],
                            $_POST['correo'],
                            password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
                            $_POST['telefono'],
                            $idDepartamento,
                            $nivel);

            $userDatabase = new User();
            $result = $userDatabase->insertUser($user);

            if ($result) {
                $this->view->message = 'Usuario ingresado correctamente';
                $this->view->departamentos = $this->cargarDepartamentos();
                $this->view->render('registro/registro');
            }
            else {
                $this->view->message = 'Error al ingresar el usuario';
                $this->view->departamentos = $this->cargarDepartamentos();
                $this->view->render('registro/registro');
            }

        }
        else {
            $this->view->departamentos = $this->cargarDepartamentos();
            $this->view->render('registro/registro');
        }
    }

    /**
     * Funcion que carga los departamentos que existen en la base
     * @return Array con los nombres de los departamentos
     */
    function cargarDepartamentos() {
        $departamentos = $this->model->cargarDepartamentos();

        return $departamentos;
    }
}

?>