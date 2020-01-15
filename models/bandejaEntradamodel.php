<?php  

session_start();

require 'models/hojaTiempo.php';
require 'models/tarea.php';

class BandejaEntradaModel extends Model{

    private $cedula;

    public function __construct(){
        parent::__construct();
    }

    public function getHojas(){
        $cedula = $_SESSION['cedula'];
        $items = [];
        try{
            $query = $this->db->connect()->prepare('SELECT usuario.departamento FROM usuario WHERE usuario.cedula = :cedula');
            $query->execute(['cedula' => $cedula]);
            $resultado = $query->fetch();
            $departamento = $resultado['departamento'];

            $query2 = $this->db->connect()->prepare('SELECT hoja_de_tiempo.id, usuario.nombre, usuario.apellido1, hoja_de_tiempo.fecha_finalizacion FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario WHERE hoja_de_tiempo.estado = 2 AND usuario.departamento = :departamento');
            $query2->execute(['departamento' => $departamento]);

            while($row = $query2->fetch()){
                $item = new HojaTiempo();
                $item->id                 = $row['id'];
                $item->nombre             = $row['nombre'];
                $item->apellido1          = $row['apellido1'];
                $item->fecha_finalizacion = $row['fecha_finalizacion'];
                array_push($items, $item);
            }
            return $items;
            
        }catch(PDOException $e){
            
            return $e;
        }
    }

    public function getTareas($hojaId){
        $items = [];
        try{

            $query = $this->db->connect()->prepare('SELECT tarea.id, tarea.nombre, tarea.descripcion, tarea.fecha_limite, tarea.proyecto, tarea.hoja_tiempo, tarea.lunes, tarea.martes, tarea.miercoles, tarea.jueves, tarea.viernes FROM hoja_de_tiempo INNER JOIN tarea ON hoja_de_tiempo.id = tarea.hoja_tiempo WHERE tarea.estado = 0 AND hoja_de_tiempo.id = :id');
            $query->execute(['id' => $hojaId]);

            while($row = $query->fetch()){
                $item = new Tarea();
                $item->id           = $row['id'];
                $item->nombre       = $row['nombre'];
                $item->descripcion  = $row['descripcion'];
                $item->fecha_limite = $row['fecha_limite'];
                $item->proyecto     = $row['proyecto'];
                $item->hoja_tiempo  = $row['hoja_tiempo'];
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

    public function updateTarea($id){
        try{
            $query = $this->db->connect()->prepare('UPDATE tarea SET tarea.estado = 1 WHERE tarea.id = :id');
            $query->execute(['id' => $id]);

        }catch(PDOException $e){
            return $e;
        }
    }

    public function updateHojaTiempo($datos){
        $hojaId = $datos['hojaId'];
        $comentarios = $datos['comentarios'];
        $nuevoEstado = $datos['nuevoEstado'];

        try{
            $query = $this->db->connect()->prepare('UPDATE hoja_de_tiempo SET hoja_de_tiempo.comentarios = :comentarios, hoja_de_tiempo.estado = :nuevoEstado WHERE hoja_de_tiempo.id = :id');
            $query->execute(['comentarios' => $comentarios, 'nuevoEstado' => $nuevoEstado, 'id' => $hojaId]);

        }catch(PDOException $e){
            return $e;
        }
    }

    public function getHojaTiempo($id) {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM hoja_de_tiempo WHERE id = :id');
            $query->execute(['id'=>$id]);

            $resultado = $query->fetch();

            return [$resultado['lunes'],
                    $resultado['martes'],
                    $resultado['miercoles'],
                    $resultado['jueves'],
                    $resultado['viernes']];
        }
        catch(PDOException $e){
            return $e;
        }
    }

}

?>