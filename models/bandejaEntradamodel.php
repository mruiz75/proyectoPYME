<?php  

session_start();

require 'models/hojaTiempo.php';

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
}

?>