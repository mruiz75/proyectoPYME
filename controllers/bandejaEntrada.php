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
		//$hojaId = $_POST['hojaId'];
		
	}
}

?>