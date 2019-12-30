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

            $query = $this->db->connect()->prepare('SELECT tarea.nombre, tarea.descripcion, tarea.fecha_limite, tarea.proyecto, tarea.hoja_tiempo, tarea.estado, tarea.lunes, tarea.martes, tarea.miercoles, tarea.jueves, tarea.viernes FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario INNER JOIN tarea ON hoja_de_tiempo.id = tarea.hoja_tiempo WHERE tarea.estado = 0 AND usuario.cedula = :cedula');
            $query->execute(['cedula' => $cedula]);

            while($row = $query->fetch()){
                $item = new Tarea();
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
}

?>