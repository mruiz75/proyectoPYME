<?php
session_start();

/**
 * Class ProyectosModel
 * Clase para el modelo de la gestion de proyectos
 */
class ProyectosModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Funcion que inserta un proyecto en la base de datos
     * @param $nombre String nombre del proyecto
     * @param $descripcion String descripcion para el proyecto
     * @param $administrador Int cedula del usuario administrador del proyecto
     * @param $departamento Int id del departamento al que pertence el proyecto
     * @return Exception en caso de error en la conexion
     */
    public function insert($nombre,$descripcion,$administrador,$departamento) {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO proyecto(nombre,descripcion,departamento,administrador)
                                                          VALUES (:nombre,:descripcion,:departamento,:administrador)');

            return $query->execute(['nombre' => $nombre,
                                    'descripcion' => $descripcion,
                                    'departamento' => $departamento,
                                    'administrador' => $administrador]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que obtiene la cedula de un usuario a traves de su nombre
     * @param $nombreCompleto Array el nombre y los apellidos del usuario
     * @return Exception en caso de error en la base
     */
    public function getCedulaFromUser($nombreCompleto) {
        try {
            $query = $this->db->connect()->prepare('SELECT cedula 
                                                              FROM usuario
                                                              WHERE nombre = :nombre AND apellido1 = :apellido1 AND apellido2 = :apellido2');

            $query->execute(['nombre'=>$nombreCompleto[0],
                             'apellido1'=>$nombreCompleto[1],
                             'apellido2'=>$nombreCompleto[2]]);

            $result = $query->fetch();

            return $result['cedula'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga los usuarios de la base para poder asignarles un proyecto
     * Si el usuario en sesion es CEO carga todos los usuarios pero si es manager solo
     * carga los usuarios de departamento
     * @return array|Exception array con los usuarios de la base o excepcion
     * en caso de error con la base
     */
    public function cargarUsuarios() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre,apellido1,apellido2 
                                                          FROM usuario');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre,apellido1,apellido2 
                                                          FROM usuario
                                                          WHERE departamento = :departamento');

                $query->execute(['departamento' => $_SESSION['departamento']]);
            }

            $usuarios = [];
            $usuario = "";

            while ($registro = $query->fetch()) {
                $usuario = $registro['nombre'] . " " . $registro['apellido1'] . " " . $registro['apellido2'];
                array_push($usuarios, $usuario);
            }

            return $usuarios;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga los proyectos de la base para poder borrarlos
     * Si el usuario en sesion es CEO carga todos los proyectos pero si es manager solo
     * carga los proyectos del departamento
     * @return array|Exception array con los proyectos de la base o excepcion
     * en caso de error con la base
     */
    public function cargarProyectos() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                            FROM proyecto');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                            FROM proyecto 
                                                            WHERE departamento = :departamento');

                $query->execute(['departamento'=>$_SESSION['departamento']]);
            }

           $proyectos = [];

           while ($result = $query->fetch()) {
               array_push($proyectos,$result['nombre']);
           }

           return $proyectos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion para borrar un proyecto de la base de datos
     * @param $nombre String nombre del proyecto a borrar
     * @return Exception en caso de error con la base
     */
    public function borrar($nombre) {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM proyecto
                                                              WHERE nombre = :nombre');

            $query->execute(['nombre'=>$nombre]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga los departamentos de la base para poder asignarles un proyecto
     * Si el usuario en sesion es CEO carga todos los departamentos pero si es manager solo
     * carga el departmaneto al que pertenece
     * @return array|Exception array con los departamentos de la base o excepcion
     * en caso de error con la base
     */
    public function cargarDepartamentos() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre FROM departamento');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                                FROM departamento
                                                                WHERE id = :id');

                $query->execute(['id'=>$_SESSION['departamento']]);
            }

            $departamentos = [];

            while ($registro=$query->fetch()){
                array_push($departamentos,$registro['nombre']);
            }

            return $departamentos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * FUncion que obtiene el id de un departamento a traves del nombre
     * @param $nombre String nombre del departamento
     * @return Exception en caso de error con la base
     */
    public function getIdFromDepartamento($nombre) {
        try {
            $query = $this->db->connect()->prepare('SELECT id FROM departamento WHERE nombre = :nombre');

            $query->execute(['nombre'=>$nombre]);

            $registro = $query->fetch();

            return $registro['id'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

}