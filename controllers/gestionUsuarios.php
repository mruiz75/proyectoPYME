<?php 

class GestionUsuarios extends Controller{

	function __construct(){
		parent::__construct();
		$this->view->render('gestionUsuarios/index');
		//echo "<p> Nuevo controlador Main </p>";
	}
}

?>