<?php

class LoginModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    /** 
     * Función que obtiene la información almacenada en base de datos, sobre el usuario que está iniciando sesión
     * Param: un arreglo con un string email y otro string contrasena.
     */
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