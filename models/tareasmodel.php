<?php

session_start();

/**
 * Class TareasModel
 * Modelo para Tarea de la base de datos
 */
class TareasModel extends Model {

    public function __construct(){
        parent::__construct();
    }

    /**
     * Funcion que inserta una tarea en la base de datos
     * @param $tarea Tarea Trae los datos de la tarea a insertar
     * @return bool True si la tarea se inserto correctamente
     * false en otro caso
     */
    public function insert($tarea, $usuario) {
        try {
            if ($usuario != "Sin asignar") {
                $query = $this->db->connect()->prepare('SELECT h.id 
                                                              FROM hoja_de_tiempo h
                                                              INNER JOIN usuario u ON h.usuario = u.cedula
                                                              WHERE u.nombre = :nombre AND u.apellido1 = :apellido1 AND u.apellido2 = :apellido2');

                $query->execute(['nombre' => $usuario[0],
                    'apellido1' => $usuario[1],
                    'apellido2' => $usuario[2]]);

                $resultado = $query->fetch();

                $idHojaTiempo = $resultado['id'];
            } else {
                $idHojaTiempo = NULL;
            }


            $query = $this->db->connect()->prepare('INSERT INTO tarea(nombre,descripcion,fecha_limite,proyecto,hoja_tiempo,estado)
                                                          VALUES (:nombre,:descripcion,:fechaLimite,:proyecto,:idHojaTiempo,0)');

            return $query->execute(['nombre' => $tarea->nombre,
                'descripcion' => $tarea->descripcion,
                'fechaLimite' => $tarea->fechaLimite,
                'proyecto' => $tarea->proyecto,
                'idHojaTiempo' => $idHojaTiempo]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que actualiza el id de hoja de tiempo en la tabla tarea
     * es decir asigna la tarea a una hoja de tiempo
     * @param $nombre String nombre de la tarea a asignar a una hoja de tiempo
     * @param $id Int id de la hoja de tiempo que se le va a asignar a la tarea
     * @return Exception|PDOException
     */
    public function updateHojaTiempo($nombre, $id) {
        try {
            $query = $this->db->connect()->prepare('UPDATE tarea SET hoja_tiempo = :id WHERE nombre = :nombre');

            $query->execute(['id' => $id, 'nombre' => $nombre]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga las tareas de la base de datos que no esten
     * asignadas a ningun usuario y pueden ser borradas
     * Si el usuario en sesion es un empleado solo cargara tareas que
     * pertenezcan a el proyecto al que administra el empleado
     * si es un manager cargara las tareas del departamento y si es
     * un CEO cargara las tareas de todos los departamentos
     * @return array|Exception|PDOException array con las tareas
     */
    public function cargarTareasABorrar() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                          FROM tarea 
                                                          WHERE hoja_tiempo IS NULL AND estado = 0');

                $query->execute();
            }
            else if ($_SESSION['posicion'] == 1) {
                $query = $this->db->connect()->prepare('SELECT t.nombre 
                                                          FROM tarea t
                                                          INNER JOIN proyecto p ON t.proyecto = p.id
                                                          WHERE hoja_tiempo IS NULL AND estado = 0 AND p.departamento = :departamento');

                $query->execute(['departamento' => $_SESSION['departamento']]);
            }
            else {
                $query = $this->db->connect()->prepare('SELECT t.nombre 
                                                          FROM tarea t
                                                          INNER JOIN proyecto p ON t.proyecto = p.id
                                                          WHERE hoja_tiempo IS NULL AND estado = 0 AND p.administrador = :cedula');

                $query->execute(['cedula' => $_SESSION['cedula']]);
            }

            $nombres = [];

            while ($registro = $query->fetch(PDO::FETCH_ASSOC)) {
                array_push($nombres, $registro['nombre']);
            }

            return $nombres;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que borra la tarea de la base de datos a traves del nombre
     * @param $nombre String nombre de la tarea
     * @return Exception|PDOException
     */
    public function borrarTarea($nombre) {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM tarea WHERE nombre = :nombre');

            $query->execute(['nombre' => $nombre]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que carga los usuarios de la base que tengan una hoja de tiempo activa
     * para poder asignarles una tarea, si el usuario en sesion es CEO carga todos los usuarios
     * Si es manager o empleado solo carga los usuarios de su departamento
     * @return array|Exception|PDOException
     */
    public function cargarUsuarios() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT u.nombre, u.apellido1, u.apellido2 
                                                          FROM usuario u 
                                                          INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario
                                                          WHERE h.estado = 1');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT u.nombre, u.apellido1, u.apellido2 
                                                          FROM usuario u 
                                                          INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario
                                                          WHERE h.estado = 1 AND u.departamento = :departamento');

                $query->execute(['departamento' => $_SESSION['departamento']]);
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
     * Funcion que carga los proyectos de la base para asignarles una tarea
     * Si el usuario en sesion es CEO carga todos los proyectos si es manager
     * carga los proyectos del departamento y si es empleado solo carga los
     * proyectos que administra
     * @return array|Exception|PDOException
     */
    public function cargarProyectos() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                          FROM proyecto');

                $query->execute();
            }
            else if ($_SESSION['posicion'] == 1) {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                          FROM proyecto
                                                          WHERE departamento = :departamento');

                $query->execute(['departamento' => $_SESSION['departamento']]);
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                          FROM proyecto
                                                          WHERE administrador = :cedula');

                $query->execute(['cedula' => $_SESSION['cedula']]);
            }

            $proyectos = [];

            while ($registro = $query->fetch()) {
                array_push($proyectos, $registro['nombre']);
            }

            return $proyectos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que obtiene el id de un proyecto a traves del nombre
     * @param $nombre String nombre del proyecto
     * @return Exception|PDOException
     */
    public function getIdFromProyecto($nombre) {
        try {
            $query = $this->db->connect()->prepare('SELECT id FROM proyecto WHERE nombre = :nombre');

            $query->execute(['nombre' => $nombre]);

            $result = $query->fetch();

            return $result['id'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

}