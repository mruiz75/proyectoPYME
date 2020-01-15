<?php


class Proyectos extends Controller {

    function __construct() {
        parent::__construct();
    }

    function render() {
        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->proyectos = $this->model->cargarProyectos();
        $this->view->render("gestionProyectos/index");
    }

    function insertar() {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $nombreCompleto = explode(" ",$_POST['administrador']);
        $cedula = $this->model->getCedulaFromUser($nombreCompleto);
        $departamentoId = $this->model->getIdFromDepartamento($_POST['departamento']);

        $result = $this->model->insert($nombre,$descripcion,$cedula,$departamentoId);

        if ($result == True) {
            $this->view->departamentos = $this->model->cargarDepartamentos();
            $this->view->usuarios = $this->model->cargarUsuarios();
            $this->view->proyectos = $this->model->cargarProyectos();
            $this->view->message = "Proyecto insertado exitosamente";
            $this->view->render("gestionProyectos/index");
        }
        else {
            $this->view->departamentos = $this->model->cargarDepartamentos();
            $this->view->usuarios = $this->model->cargarUsuarios();
            $this->view->proyectos = $this->model->cargarProyectos();
            $this->view->message = "No se pudo ingresar el proyecto";
            $this->view->render("gestionProyectos/index");
        }
    }

    function borrar() {
        $this->model->borrar($_POST['proyecto']);

        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->proyectos = $this->model->cargarProyectos();
        $this->view->message = "Proyecto ".$_POST['proyecto']." borrado exitosamente";
        $this->view->render("gestionProyectos/index");
    }

}