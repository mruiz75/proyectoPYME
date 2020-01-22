<?php 
session_start();

/**
 * Class Usuarios
 * Clase para el controller de la gestion de usuarios
 */
class Usuarios extends Controller{

	function __construct(){
		parent::__construct();
	}

    /**
     * Funcion principal que carga la vista asociada
     */
	function render(){
        $this->view->puestos = $this->cargarPuestos();
	    $this->view->departamentos = $this->model->cargarDepartamentos();
	    $this->view->usuarios = $this->model->cargarUsuarios();
		$this->view->render('gestionUsuarios/index');
	}

    /**
     * Funcion que cambia de departamento a un usuario a traves del modelo
     * obtiene el id del departamento a traves del nombre
     */
	function cambiarDepartamento() {
	    $departamentoId = $this->model->getDepartamentoId($_POST['departamento']);
	    $nombreCompleto = explode(" ",$_POST['usuario']);
	    $this->model->cambiarDepartamento($nombreCompleto, $departamentoId);

	    $this->view->message = "Usuario ".$_POST['usuario']." cambiado al departamento ".$_POST['departamento'];
        $this->view->puestos = $this->cargarPuestos();
        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->render('gestionUsuarios/index');
    }

    /**
     * Funcion que cambia la posicion de un usuario en la base a traves del modelo
     */
    function ascender() {
	    $nombreCompleto = explode(" ",$_POST['usuario']);

	    switch ($_POST['puesto']) {
            case 'Manager':
                $posicion = 1;
                break;
            case 'Empleado':
                $posicion = 2;
                break;
            case 'CEO':
                $posicion = 0;
                break;
        }

	    $this->model->ascender($nombreCompleto,$posicion);

	    $this->view->message = "Usuario ".$_POST['usuario']." con puesto de ".$_POST['puesto'];
	    $this->view->puestos = $this->cargarPuestos();
        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->render('gestionUsuarios/index');
    }

    /**
     * Funcion que carga las opciones de los puestos para ascender o degradar un usuario
     * @return array con las opciones "Manager" y "Empleado" en caso de que el usuario en sesion
     * sea un manager o ademas "CEO" en caso de que sea un CEO el usuario en sesion
     */
    function cargarPuestos() {
	    $puestos = ["Manager","Empleado"];

	    if ($_SESSION['posicion'] == 0) {
	        array_push($puestos,"CEO");
        }

	    return $puestos;
    }
}

?>