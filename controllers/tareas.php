<?php
include_once 'models/tarea.php';
include_once 'models/tareaModel.php';
include_once 'models/proyectoModel.php';

class Tareas extends Controller {

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

               $tareaModel = new TareaModel();

               $resultado = $tareaModel->insert($tarea);

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

}