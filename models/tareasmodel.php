<?php

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
    public function insert($tarea) {

        $query = $this->db->connect()->prepare('INSERT INTO tarea(nombre,descripcion,fecha_limite,proyecto,estado)
                                                          VALUES (:nombre,:descripcion,:fechaLimite,:proyecto,0)');

        return $query->execute(['nombre'=>$tarea->nombre,
                                'descripcion'=>$tarea->descripcion,
                                'fechaLimite'=>$tarea->fechaLimite,
                                'proyecto'=>$tarea->proyecto]);


    }

    /**
     * Funcion que actualiza el id de hoja de tiempo en la tabla tarea
     * es decir asigna la tarea a una hoja de tiempo
     * @param $nombre String nombre de la tarea a asignar a una hoja de tiempo
     * @param $id Int id de la hoja de tiempo que se le va a asignar a la tarea
     */
    public function updateHojaTiempo($nombre, $id) {

        $query = $this->db->connect()->prepare('UPDATE tarea SET hoja_tiempo = :id WHERE nombre = :nombre');

        $query->execute(['id'=>$id,'nombre'=>$nombre]);
    }

    public function cargarTareasABorrar() {
        $query = $this->db->connect()->prepare('SELECT nombre FROM tarea WHERE hoja_tiempo IS NULL AND estado = 0');

        $query->execute();

        $nombres = [];

        while ($registro=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($nombres,$registro['nombre']);
        }

        return $nombres;
    }

    public function borrarTarea($nombre) {
        $query = $this->db->connect()->prepare('DELETE FROM tarea WHERE nombre = :nombre');

        $query->execute(['nombre'=>$nombre]);
    }

}