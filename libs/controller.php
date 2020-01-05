<?php

class Controller{

    function __construct(){
        $this->view = new View();
        //echo "<p>Controlador principal</p>";
    }

    function loadModel($model){
        $url = 'models/'.$model.'model.php';

        if(file_exists($url)){
            echo $url;
            require $url;
            $modelName = $model.'Model';
            echo $modelName;
            $this->model = new $modelName();
        }
    }
}
?>