<?php

include_once 'database.php';

class User extends database{

    private $cedula;
    private $nombre;
    private $correo;
    private $contrasena;
    private $posicion;

    public function userExists($correo, $contrasena){

        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE correo = :correo');
        $query->execute(['correo' => $correo]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if(password_verify($contrasena,$result['contrasena'])){
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

    function insertUser($user) {

        $query = $this->connect()->prepare('INSERT INTO usuario 
                                                      VALUES(:cedula,:nombre,:apellido1,:apellido2,:correo,:contrasena,:telefono,1,1)');


        return $query->execute(['cedula' => $user->getCedula(),
            'nombre' => $user->getNombre(),
            'apellido1' => $user->getApellido1(),
            'apellido2' => $user->getApellido2(),
            'correo' => $user->getCorreo(),
            'contrasena' => $user->getContrasena(),
            'telefono' => $user->getTelefono()]);
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