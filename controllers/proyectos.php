<?php

/**
 * Class Proyectos
 * Clase del controller para la gestion de proyectos
 */
class Proyectos extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion que carga la vista asociada al controller
     */
    function render() {
        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->proyectos = $this->model->cargarProyectos();
        $this->view->render("gestionProyectos/index");
    }

    /**
     * Funcion que inserta un proyecto a traves del modelo
     * obtiene la cedula y el id del departamento a traves del nombre
     */
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

    /**
     * Funcion que borra un proyecto a traves del modelo
     */
    function borrar() {
        $this->model->borrar($_POST['proyecto']);

        $this->view->departamentos = $this->model->cargarDepartamentos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->proyectos = $this->model->cargarProyectos();
        $this->view->message = "Proyecto ".$_POST['proyecto']." borrado exitosamente";
        $this->view->render("gestionProyectos/index");
    }

}