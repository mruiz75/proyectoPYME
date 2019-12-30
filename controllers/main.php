<?php 

class Main extends Controller{

	public $userPosition;

	function __construct(){
		parent::__construct();
	}

	function render($userPos){
		$this->userPosition = $userPos;
		if($this->userPosition == 1){
			parent::__construct();
			$this->view->render('hojaDeTiempo/index');
		}else{
			parent::__construct();
			$this->view->render('hojaDeTiempo/index2');
		}
	}

	function saludo(){
		echo "<p>Ejecutaste el metodo saludo</p>";
	}
}

?>