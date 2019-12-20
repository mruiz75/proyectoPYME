<?php 

class Main extends Controller{

	public $userPosition;

	function __construct($userPos){
		$this->userPosition = $userPos;
		if($this->userPosition == 1){
			parent::__construct();
			$this->view->render('main/index');
		}else{
			parent::__construct();
			$this->view->render('main/index2');
		}
		//echo "<p> Nuevo controlador Main </p>";
	}


	function saludo(){
		echo "<p>Ejecutaste el metodo saludo</p>";
	}
}

?>