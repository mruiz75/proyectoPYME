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

    function verTareas(){

    }
}

?>