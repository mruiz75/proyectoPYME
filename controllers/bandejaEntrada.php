<?php 

class BandejaEntrada extends Controller{

	function __construct(){
		parent::__construct();
	}

	function render(){
		$hojas_de_tiempo = $this->model->getHojas();
		$this->view->hojas = $hojas_de_tiempo;
		$this->view->render('bandejaEntrada/index');
	}

	function abrir(){
		$hojaId = $_POST['hojaId'];
		$tareas = $this->model->getTareas($hojaId);
		$horas = $this->model->getHojaTiempo($hojaId);

		$totalHoras = 0;
        foreach ($horas as &$hora) {
            $totalHoras += $hora;
		}

        $this->view->horas = $horas;
        $this->view->totalHoras = $totalHoras;
		$this->view->tareas = $tareas;
		$this->view->render('bandejaEntrada/gestionHoja');
	}

	function aceptar(){
		$count = count($_POST['id']);
		$hojaId = $_POST['hojaId'];
		$comentarios = $_POST['comentarios'];
		$nuevoEstado = 0;

        for($i=0; $i < $count; $i++){
			$id = $_POST['id'][$i];
            $this->model->updateTarea($id);
		}
		$this->model->updateHojaTiempo(['hojaId' => $hojaId, 'comentarios' => $comentarios, 'nuevoEstado' => $nuevoEstado]);
		$this->render();
	}

	function rechazar(){
		$hojaId = $_POST['hojaId'];
		$comentarios = $_POST['comentarios'];
		$nuevoEstado = 1;

		$this->model->updateHojaTiempo(['hojaId' => $hojaId, 'comentarios' => $comentarios, 'nuevoEstado' => $nuevoEstado]);
		$this->render();
	}
}

?>