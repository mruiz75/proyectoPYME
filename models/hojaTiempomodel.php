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
                $item->fechaLimite  = $row['fecha_limite'];
                $item->proyecto     = $row['proyecto'];
                $item->hojaTiempo   = $row['hoja_tiempo'];
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

    public function getInfoHojaTiempo(){
        $cedula = $_SESSION['cedula'];

        try{
            $query = $this->db->connect()->prepare('SELECT * FROM hoja_de_tiempo INNER JOIN usuario ON usuario.cedula = hoja_de_tiempo.usuario WHERE usuario.cedula = :cedula AND hoja_de_tiempo.estado != 0;');
            $query->execute(['cedula' => $cedula]);
            $resultado = $query->fetch();
            $estado = $resultado['estado'];
            $comentarios = $resultado['comentarios'];
            $lunes = $resultado['lunes'];
            $martes = $resultado['martes'];
            $miercoles = $resultado['miercoles'];
            $jueves = $resultado['jueves'];
            $viernes = $resultado['viernes'];
            return [$estado,$comentarios,$lunes,$martes,$miercoles,$jueves,$viernes];

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
            $query = $this->db->connect()->prepare('UPDATE tarea SET tarea.lunes = :lunes, tarea.martes = :martes, tarea.miercoles = :miercoles, tarea.jueves = :jueves, tarea.viernes = :viernes WHERE tarea.id = :id AND tarea.hoja_tiempo = (SELECT hoja_de_tiempo.id FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario where usuario.cedula = :cedula AND hoja_de_tiempo.estado = 1)');
            $query->execute(['id' => $id, 'lunes' => $lunes, 'martes' => $martes, 'miercoles' => $miercoles, 'jueves' => $jueves, 'viernes' => $viernes, 'cedula' => $cedula]);
        
        }catch(PDOException $e){
            return $e;
        }
    }

    public function updateHojaTiempoRevision($dias){
        //necesito agregar fecha de finalizacion y cambiar estado a 0 = inactiva
        $cedula = $_SESSION['cedula'];
        
        try{
            $query = $this->db->connect()->prepare('UPDATE hoja_de_tiempo 
                                                            SET estado = 2, fecha_finalizacion = NOW(), lunes = :lunes, martes = :martes, miercoles = :miercoles, jueves = :jueves, viernes = :viernes 
                                                            WHERE usuario = :cedula AND estado = 1');
            $query->execute(['cedula' => $cedula,
                             'lunes'=>$dias[0],
                             'martes'=>$dias[1],
                             'miercoles'=>$dias[2],
                             'jueves'=>$dias[3],
                             'viernes'=>$dias[4]]);
        }catch(PDOException $e){
            echo $e;
            return $e;
        }
    }

    public function getId() {
        $cedula = $_SESSION['cedula'];

        $query = $this->db->connect()->prepare('SELECT id FROM hoja_de_tiempo WHERE usuario = :cedula AND estado = 1');

        $query->execute(['cedula'=>$cedula]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }

    public function cargarTareas() {
        try{
            $query = $this->db->connect()->prepare('SELECT t.nombre 
                                                  FROM tarea t 
                                                  INNER JOIN proyecto p ON t.proyecto = p.id
                                                  INNER JOIN usuario u ON p.departamento = u.departamento
                                                  WHERE t.hoja_tiempo IS NULL AND t.estado = 0 AND u.cedula = :cedula');

            $query->execute(['cedula'=>$_SESSION['cedula']]);

            $tareas = [];

            while ($result=$query->fetch()) {
                array_push($tareas,$result['nombre']);
            }

            return $tareas;
        }
        catch(PDOException $e){
            return $e;
        }
    }
}

?>