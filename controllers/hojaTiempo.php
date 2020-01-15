<?php

class HojaTiempo extends Controller{


    function __construct(){
        parent::__construct();
        $this->view->tareas = [];
    }

    function render(){
        $tareas = $this->model->getTareas();
        $datos = $this->model->getInfoHojaTiempo();
        $this->view->tareasMostrar = $this->model->cargarTareas();
        $this->view->id = $this->model->getId();
        $this->view->tareas = $tareas;
        $this->view->comentarios = $datos[1];
        $this->view->lunes = $datos[2];
        $this->view->martes = $datos[3];
        $this->view->miercoles = $datos[4];
        $this->view->jueves = $datos[5];
        $this->view->viernes = $datos[6];
        if($datos[0] == 1){
            $this->view->render('hojaTiempo/index');
        }else{
            $this->view->render('hojaTiempo/indexRevision');
        }
    }

    function enviarRevision(){

        $count = count($_POST['lunes']);

        for($i=0; $i < $count; $i++){
            $id = $_POST['id'][$i];
            $lunes = $_POST['lunes'][$i];
            $martes = $_POST['martes'][$i];
            $miercoles = $_POST['miercoles'][$i];
            $jueves = $_POST['jueves'][$i];
            $viernes = $_POST['viernes'][$i];
            $this->model->updateTareas(['id' => $id, 'lunes' => $lunes, 'martes' => $martes, 'miercoles' => $miercoles, 'jueves' => $jueves, 'viernes' => $viernes]);
        }

        $this->model->updateHojaTiempoRevision($_POST['libre']);
        //crear un view que muestre la hoja de tiempo con las horas fijas (no inputs)
        //y que despliegue los comentarios abajo.
        $this->render();        
    }
}

?>