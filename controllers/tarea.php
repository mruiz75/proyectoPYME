<?php
include_once 'models/tarea.php';
include_once 'models/proyectoModel.php';

class Tarea extends Controller {

    function __construct() {
        parent::__construct();
    }

    function render() {

        if (isset($_POST['descripcion'])) {
               $tarea = new Tarea();
               $tarea->nombre = $_POST['nombre'];
               $tarea->descripcion = $_POST['descripcion'];
               $tarea->fechaLimite = $_POST['fecha'];

               $proyectoModel = new ProyectoModel();
               $id = $proyectoModel->getId($_POST['proyecto']);

               $tarea->proyecto = $id;

               $resultado = $this->model->insert($tarea);

               if ($resultado) {
                   $this->view->message = 'Tarea insertada correctamente';
                   $this->view->render('tareas/index');
               }
               else {
                   $this->view->message = 'Hubo un error al insertar la tarea';
                   $this->view->render('tareas/index');
               }
        }
        else {
            $this->view->render('tareas/index');
        }
    }

    function asignar($array) {
        $nombre = $array[1];

        $this->model->updateHojaTiempo($nombre);

        require constant('URL').'hojaTiempo';
    }

}