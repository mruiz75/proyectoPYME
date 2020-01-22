<?php
include_once 'models/tarea.php';

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
     */
    function render() {
        $this->view->tareas = $this->model->cargarTareasABorrar();
        $this->view->proyectos = $this->model->cargarProyectos();
        $this->view->usuarios = $this->model->cargarUsuarios();
        $this->view->render('gestionTareas/index');
    }

    /**
     * Funcion que inserta una tarea a traves del modelo
     * verifica que la fecha limite no sea anterior a la actual
     * y obtiene el id del proyecto a traves del nombre
     */
    function insertar() {
        $tarea = new Tarea();
        $tarea->nombre = $_POST['nombre'];
        $tarea->descripcion = $_POST['descripcion'];

        if (date('Y-m-d') > $_POST['fecha']) {
            $this->view->message = 'La fecha de caducidad debe ser mayor a la fecha actual';
            $this->view->tareas = $this->model->cargarTareasABorrar();
            $this->view->proyectos = $this->model->cargarProyectos();
            $this->view->usuarios = $this->model->cargarUsuarios();
            $this->view->render('gestionTareas/index');
        }

        else {
            $tarea->fechaLimite = $_POST['fecha'];

            $id = $this->model->getIdFromProyecto($_POST['proyecto']);
            $tarea->proyecto = $id;

            if ($_POST['usuario'] != "Sin asignar") {
                $nombreCompleto = explode(" ", $_POST['usuario']);
                $resultado = $this->model->insert($tarea, $nombreCompleto);
            } else {
                $resultado = $this->model->insert($tarea, $_POST['usuario']);
            }

            if ($resultado == True) {
                $this->view->message = 'Tarea insertada correctamente';
                $this->view->tareas = $this->model->cargarTareasABorrar();
                $this->view->proyectos = $this->model->cargarProyectos();
                $this->view->usuarios = $this->model->cargarUsuarios();
                $this->view->render('gestionTareas/index');

            } else {
                $this->view->message = 'Hubo un error al insertar la tarea';
                $this->view->tareas = $this->model->cargarTareasABorrar();
                $this->view->proyectos = $this->model->cargarProyectos();
                $this->view->usuarios = $this->model->cargarUsuarios();
                $this->view->render('gestionTareas/index');
            }
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

    /**
     * Funcion que borra una tarea a traves del modelo
     */
    function borrar() {
        $this->model->borrarTarea($_POST['tarea']);

        $this->view->message = 'Tarea '.$_POST['tarea'].' borrada correctamente';
        $this->view->tareas = $this->mostrarTareas();
        $this->view->render('tareas/index');
    }
}
