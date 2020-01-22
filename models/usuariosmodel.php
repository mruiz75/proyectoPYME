<?php

 
if(!isset($_SESSION['nombre'])){
    session_start();
}

/**
 * Class UsuariosModel
 * Clase para el modelo de la gestion de usuarios
 */
class UsuariosModel extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion que carga los usuarios de la base
     * Si el usuario en sesion es CEO carga todos los usuarios
     * si es manager carga los usuarios del departamento
     * @return array|Exception|PDOException array con los usuarios
     */
    public function cargarUsuarios() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT u.nombre, u.apellido1, u.apellido2 
                                                          FROM usuario u 
                                                          WHERE cedula != :cedula');

                $query->execute(['cedula'=>$_SESSION['cedula']]);
            }
            else {
                $query = $this->db->connect()->prepare('SELECT u.nombre, u.apellido1, u.apellido2 
                                                          FROM usuario u 
                                                          WHERE u.departamento = :departamento AND cedula != :cedula');

                $query->execute(['departamento' => $_SESSION['departamento'],
                    'cedula'=>$_SESSION['cedula']]);
            }

            $nombres = [];
            $nombre = "";

            while ($registro = $query->fetch(PDO::FETCH_ASSOC)) {
                $nombre = $registro['nombre'] . " " . $registro['apellido1'] . " " . $registro['apellido2'];
                array_push($nombres, $nombre);
            }

            return $nombres;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga los departamentos de la base
     * @return array|Exception|PDOException array con los departamentos
     */
    public function cargarDepartamentos() {
        try {
            $query = $this->db->connect()->prepare('SELECT nombre 
                                                            FROM departamento');

            $query->execute();

            $departamentos = [];

            while ($registro = $query->fetch()) {
                array_push($departamentos, $registro['nombre']);
            }

            return $departamentos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que obtiene el id de un departamento a traves del nombre
     * @param $nombre String nombre del departamento
     * @return Exception|PDOException
     */
    public function getDepartamentoId($nombre) {
        try {
            $query = $this->db->connect()->prepare('SELECT id
                                                              FROM departamento
                                                              WHERE nombre = :nombre');

            $query->execute(['nombre'=>$nombre]);

            $registro = $query->fetch();

            return $registro['id'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que cambia un usuario de departamento, lo busca a traves del nombre
     * @param $nombreCompleto Array con nombre y apellidos del usario
     * @param $departamentoId Int id del departamento al que se movera el usuario
     * @return Exception|PDOException
     */
    public function cambiarDepartamento($nombreCompleto, $departamentoId) {
        try {
            $this->quitarTareasYProyecto($nombreCompleto);

            $query = $this->db->connect()->prepare('UPDATE usuario
                                                              SET departamento = :id
                                                              WHERE nombre = :nombre AND apellido1 = :apellido1 AND apellido2 = :apellido2');

            $query->execute(['id'=>$departamentoId,
                             'nombre'=>$nombreCompleto[0],
                             'apellido1'=>$nombreCompleto[1],
                             'apellido2'=>$nombreCompleto[2]]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que cambia la posicion de un usuario en la base, lo busca a traves del nombre
     * @param $nombreCompleto Array nombre y apellidos del usuario
     * @param $posicion 0 si es CEO, 1 si es manager o 2 si es empleado
     * @return Exception|PDOException
     */
    public function ascender($nombreCompleto, $posicion) {
        try {
            $query = $this->db->connect()->prepare('UPDATE usuario 
                                                              SET posicion = :posicion
                                                              WHERE nombre = :nombre AND apellido1 = :apellido1 AND apellido2 = :apellido2');

            $query->execute(['posicion'=>$posicion,
                'nombre'=>$nombreCompleto[0],
                'apellido1'=>$nombreCompleto[1],
                'apellido2'=>$nombreCompleto[2]]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que quita las tareas y proyectos asignados a un usuario que sera cambiado
     * de departamento
     * @param $nombreCompleto Array nombre y apellidos del usuario
     * @return Exception|PDOException
     */
    function quitarTareasYProyecto($nombreCompleto) {
        try {
            $query = $this->db->connect()->prepare('SELECT cedula 
                                                            FROM usuario 
                                                            WHERE nombre = :nombre AND apellido1 = :apellido1 AND apellido2 = :apellido2 ');

            $query->execute(['nombre'=>$nombreCompleto[0],
                            'apellido1'=>$nombreCompleto[1],
                            'apellido2'=>$nombreCompleto[2]]);

            $registro = $query->fetch();

            $query = $this->db->connect()->prepare('SELECT id
                                                              FROM hoja_de_tiempo
                                                              WHERE usuario = :usuario');

            $query->execute(['usuario'=>$registro['cedula']]);

            $query2 = $this->db->connect()->prepare('UPDATE proyecto 
                                                            SET administrador = NULL
                                                            WHERE administrador = :cedula');

            $query2->execute(['cedula'=>$registro['cedula']]);

            $registro = $query->fetch();

            $query = $this->db->connect()->prepare('UPDATE tarea
                                                              SET hoja_tiempo = NULL
                                                              WHERE hoja_tiempo = :id');

            $query->execute(['id'=>$registro['id']]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

}