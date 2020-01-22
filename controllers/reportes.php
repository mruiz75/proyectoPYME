<?php

/**
 * Class Reportes
 * Clase del controller para la gestion de reportes
 */
class Reportes extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion principal que carga la vista asociada al controller
     */
    function render() {
        $this->view->render('reportes/index');
    }

    /**
     * Funcion que genera un reporte a traves del modelo
     * verifica si ya hay un reporte semanal creado
     */
    function generar() {
        $departamento = $this->model->getDepartamento();

        $query = $this->model->buscarReporte(0,0,$departamento);

        if ($query->rowCount() == 0) {

            $this->model->generarReporte();

            $this->view->mensaje = "Reporte semanal del departamento " . $departamento . " generado exitosamente";
            $this->view->render('reportes/index');
        }
        else {
            $this->view->mensaje = "Ya existe un reporte semanal del departamento " . $departamento;
            $this->view->render('reportes/index');
        }
    }

    /**
     * Funcion que busca reportes en dos fechas establecidas por el usuario
     */
    function buscar() {
        $departamento = $this->model->getDepartamento();

        $query = $this->model->buscarReporte($_POST['fechaDesde'],$_POST['fechaHasta'],$departamento);

        if ($query->rowCount() == 0) {
            $this->view->mensaje = "No existen reportes del ".$_POST['fechaDesde']." al ".$_POST['fechaHasta']." para el departamento ".$departamento;
            $this->view->render('reportes/index');
        }
        else {
            $this->view->query = $query;
            $this->view->render('reportes/index');
        }


    }
}