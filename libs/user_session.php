<?php 

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentNombre($nombre){
        $_SESSION['nombre'] = $nombre;
    }

    public function getCurrentNombre(){
        return $_SESSION['nombre'];
    }

    public function setCurrentEmail($email){
        $_SESSION['email'] = $email;
    }

    public function getCurrentEmail(){
        return $_SESSION['email'];
    }

    public function setCurrentPosicion($posicion){
        $_SESSION['posicion'] = $posicion;
    }

    public function getCurrentPosicion(){
        return $_SESSION['posicion'];
    }

    public function setCurrentCedula($cedula){
        $_SESSION['cedula'] = $cedula;
    }

    public function getCurrentCedula(){
        return $_SESSION['cedula'];
    }

    public function setCurrentDepartamento($departamento) {
        $_SESSION['departamento'] = $departamento;
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }

    public function setAdministrador($bandera) {
        $_SESSION['administrador'] = $bandera;
    }
}

?>