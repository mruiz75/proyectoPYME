<?php

/**
 * Archivo que estructura el funcionamiento de los controladores
 */
class Controller{

    function __construct(){
        $this->view = new View();
        //echo "<p>Controlador principal</p>";
    }

    /**
     * Función encargada de llamar al modelo indicado
     * param: un string con el nombre del modelo al que se llama. 
     */
    function loadModel($model){
        $url = 'models/'.$model.'model.php';

        if(file_exists($url)){
            require $url;
            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }
}
?>