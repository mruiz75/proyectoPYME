<?php  

session_start();

require 'models/tarea.php';

class HojaTiempoModel extends Model{

    private $cedula;

    public function __construct(){
        parent::__construct();
    }

    public function getTareas(){
        $cedula = $_SESSION['cedula'];
        $items = [];
        try{

            $query = $this->db->connect()->prepare('SELECT tarea.id, tarea.nombre, tarea.descripcion, tarea.fecha_limite, tarea.proyecto, tarea.hoja_tiempo, tarea.estado, tarea.lunes, tarea.martes, tarea.miercoles, tarea.jueves, tarea.viernes FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario INNER JOIN tarea ON hoja_de_tiempo.id = tarea.hoja_tiempo WHERE tarea.estado = 0 AND usuario.cedula = :cedula');
            $query->execute(['cedula' => $cedula]);

            while($row = $query->fetch()){
                $item = new Tarea();
                $item->id           = $row['id'];
                $item->nombre       = $row['nombre'];
                $item->descripcion  = $row['descripcion'];
                $item->fecha_limite = $row['fecha_limite'];
                $item->proyecto     = $row['proyecto'];
                $item->hoja_tiempo  = $row['hoja_tiempo'];
                $item->estado       = $row['estado'];
                $item->lunes        = $row['lunes'];
                $item->martes       = $row['martes'];
                $item->miercoles    = $row['miercoles'];
                $item->jueves       = $row['jueves'];
                $item->viernes      = $row['viernes'];
                array_push($items, $item);
            }
            return $items;
            
        }catch(PDOException $e){
            return [];
        }
    }

    public function getEstadoHojaTiempo(){
        $cedula = $_SESSION['cedula'];

        try{
            $query = $this->db->connect()->prepare('SELECT hoja_de_tiempo.estado FROM hoja_de_tiempo INNER JOIN usuario ON usuario.cedula = hoja_de_tiempo.usuario WHERE usuario.cedula = :cedula AND hoja_de_tiempo.estado != 0;');
            $query->execute(['cedula' => $cedula]);
            $resultado = $query->fetch();
            $estado = $resultado['estado'];
            return $estado;

        }catch(PDOException $e){
            return $e;
        }
    }

    public function updateTareas($datos){
        //necesito agregar tiempos y cambiar estado a 1 = finalizadas
        $cedula = $_SESSION['cedula'];
        $id = $datos['id'];
        $lunes = $datos['lunes'];
        $martes = $datos['martes'];
        $miercoles = $datos['miercoles'];
        $jueves = $datos['jueves'];
        $viernes = $datos['viernes'];
        try{

            $query = $this->db->connect()->prepare('UPDATE tarea SET tarea.lunes = :lunes, tarea.martes = :martes, tarea.miercoles = :miercoles, tarea.jueves = :jueves, tarea.viernes = :viernes WHERE tarea.id = CAST(:id AS INT) AND tarea.hoja_tiempo = (SELECT hoja_de_tiempo.id FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario where usuario.cedula = :cedula AND hoja_de_tiempo.estado = 1)');
            $query->execute(['id' => $id, 'lunes' => $lunes, 'martes' => $martes, 'miercoles' => $miercoles, 'jueves' => $jueves, 'viernes' => $viernes, 'cedula' => $cedula]);
        }catch(PDOException $e){
            return $e;
        }
    }

    public function updateHojaTiempoRevision(){
        //necesito agregar fecha de finalizacion y cambiar estado a 0 = inactiva
        $cedula = $_SESSION['cedula'];
        
        try{
            $query = $this->db->connect()->prepare('UPDATE hoja_de_tiempo SET hoja_de_tiempo.estado = 2, hoja_de_tiempo.fecha_finalizacion = NOW() WHERE hoja_de_tiempo.usuario = :cedula AND hoja_de_tiempo.estado = 1');
            $query->execute(['cedula' => $cedula]);
        }catch(PDOException $e){
            return $e;
        }
    }
}

?>