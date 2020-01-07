<?php


class TareasModel extends Model {

    public function __construct(){
        parent::__construct();
    }


    public function insert($tarea) {

        $query = $this->db->connect()->prepare('INSERT INTO tarea(nombre,descripcion,fecha_limite,proyecto,estado)
                                                          VALUES (:nombre,:descripcion,:fechaLimite,:proyecto,0)');

        return $query->execute(['nombre'=>$tarea->nombre,
                                'descripcion'=>$tarea->descripcion,
                                'fechaLimite'=>$tarea->fechaLimite,
                                'proyecto'=>$tarea->proyecto]);


    }



    public function updateHojaTiempo($nombre) {
        $hojaTiempoModel = new HojaTiempoModel();

        $id = $hojaTiempoModel->getId();

        $query = $this->db->connect()->prepare('UPDATE tarea SET hoja_tiempo = :id WHERE nombre = :nombre');

        $query->execute(['id'=>$id,'nombre'=>$nombre]);
    }

}