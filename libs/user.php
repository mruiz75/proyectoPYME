<?php

include_once 'database.php';

class User extends database{

    private $cedula;
    private $nombre;
    private $correo;
    private $contrasena;
    private $posicion;

    public function userExists($correo, $contrasena){
        $md5pass = md5($contrasena);

        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE correo = :correo AND contrasena = :contrasena');
        $query->execute(['correo' => $correo, 'contrasena' => $contrasena]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($correo){
        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE correo = :correo');
        $query->execute(['correo' => $correo]);

        foreach($query as $currentUser){
            $this->cedula = $currentUser['cedula'];
            $this->nombre = $currentUser['nombre'];
            $this->posicion = $currentUser['posicion'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getCedula(){
        return $this->cedula;
    }

    public function getPosicion(){
        return $this->posicion;
    }

}

?>