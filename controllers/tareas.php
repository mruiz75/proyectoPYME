<?php
include_once 'models/tarea.php';
include_once 'models/proyectoModel.php';

/**
 * Class Tareas
 * Controller para la gestion de tareas
 */
class Tareas extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion principal del controller que muestra la vista
     * o inserta una tarea llamando al modelo
     * utiliza el archivo ProyectoModel para obtener el id del proyecto
     * al que pertenece la tarea
     */
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
                $this->view->tareas = $this->mostrarTareas();
                $this->view->render('gestionTareas/index');
            }
            else {
                $this->view->message = 'Hubo un error al insertar la tarea';
                $this->view->tareas = $this->mostrarTareas();
                $this->view->render('gestionTareas/index');
            }
        }
        else {
            $this->view->tareas = $this->mostrarTareas();
            $this->view->render('gestionTareas/index');
        }
    }

    /**
     * Funcion que asigna una tarea a un usuario, es decir
     * asigna la tarea a la hoja de tiempo que pertenece a el usuario
     * @param $array ArrayObject Una lista con los parametros de la siguiente forma
     * en la posicion uno se encuentra el nombre de la tarea a asignar
     * en la posicion dos el id de la hoja de tiempo que pertence al usuario
     */
    function asignar($array) {
        $nombre = $array[0];
        $id = $array[1];

        $this->model->updateHojaTiempo($nombre, $id);

        header('Location: '.constant('URL').'hojaTiempo');
    }

    function mostrarTareas() {
        $tareas = $this->model->cargarTareasABorrar();

        return $tareas;
    }

    function borrar() {
        $this->model->borrarTarea($_POST['tarea']);

        $this->view->message = 'Tarea '.$_POST['tarea'].' borrada correctamente';
        $this->view->tareas = $this->mostrarTareas();
        $this->view->render('tareas/index');
    }

    function mostrarUsuarios() {
        
    }

}