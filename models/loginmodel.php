<?php

class LoginModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function getUser($datos){

        $query = $this->db->connect()->prepare('SELECT * FROM usuario WHERE correo = :correo AND contrasena = :contrasena');

        try{
            $query->execute([
                'correo' => $datos['correo'],
                'contrasena' => $datos['contrasena']
            ]);
            $resultado = $query->fetch();
            $posicion = $resultado['posicion'];

            return $posicion;
        }catch(PDOException $e){
            return null;
        }
    }
}
?>