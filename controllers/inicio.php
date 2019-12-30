<?php

class Inicio extends Controller{

    function __construct(){
        parent::__construct(); 
    }

    function render(){
        $this->view->render('inicio/index');
    }
}

?>