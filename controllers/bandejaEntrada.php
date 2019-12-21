<?php 

class BandejaEntrada extends Controller{

	function __construct(){
		parent::__construct();
		$this->view->render('bandejaEntrada/index');
		//echo "<p> Nuevo controlador Main </p>";
	}
}

?>