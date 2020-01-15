<?php 
session_start();
class Usuarios extends Controller{

	function __construct(){
		parent::__construct();
	}

	function render(){
        $this->view->puestos = $this->cargarPuestos();
	    $this->view->departamentos = $this->model->cargarDepartamentos();
	    $this->view->usuarios = $this->model->cargarUsuarios();
		$this->view->render('gestionUsuarios/index');
	}

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

    function cargarPuestos() {
	    $puestos = ["Manager","Empleado"];

	    if ($_SESSION['posicion'] == 0) {
	        array_push($puestos,"CEO");
        }

	    return $puestos;
    }
}

?>