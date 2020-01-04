<?php

class HojaTiempo extends Controller{


    function __construct(){
        parent::__construct();
        $this->view->tareas = [];
    }

    function render(){
        $tareas = $this->model->getTareas();
        $this->view->tareas = $tareas;
        $this->view->render('hojaTiempo/index');
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

        //$this->model->updateHojaTiempo();
        //crear un view que muestre la hoja de tiempo con las horas fijas (no inputs)
        //y que despliegue los comentarios abajo.
        
        $tareas = $this->model->getTareas();
        $this->view->tareas = $tareas;
        $this->view->render('hojaTiempo/index');
    }
}

?>