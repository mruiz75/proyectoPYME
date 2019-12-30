<?php 

class Login extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje="";
        
    }

    function verificar(){
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        $posicion = $this->model->getUser(['correo' => $correo, 'contrasena' => $contrasena]);

        if($posicion == 1){
            //header('location: '.constant('URL').'nuevo/alumnoCreado');
            $this->view->correo = $correo;
            $this->view->posicion = $posicion;
            $this->view->render('hojaTiempo/index');

        }elseif($posicion == 2){
            $this->view->correo = $correo;
            $this->view->posicion = $posicion;
            $this->view->render('hojaTiempo/index2');
        
        }else{
            $this->view->mensaje = "El usuario o la contraseña ingresada no son correctos.";
            $this->view->render('index/index');
        }
    }
}

?>