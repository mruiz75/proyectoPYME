<?php

session_start();

/**
 * Class ReportesModel
 * Clase para el modelo de gestion de reportes
 */
class ReportesModel extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion que obtiene el nombre del departamento al que pertenece
     * el usuario en sesion
     * @return Exception en caso de error con la base
     */
    public function getDepartamento() {
        try {
            $query = $this->db->connect()->prepare('SELECT nombre FROM departamento WHERE id = :id');

            $query->execute(['id'=>$_SESSION['departamento']]);

            $resultado = $query->fetch();

            return $resultado['nombre'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que genera un reporte en la base de datos del departamento
     * al que pertenece el usuario en sesion lo hace llamando a un procedimiento
     * almacenado de la base que se encarga de generar el reporte
     * @return Exception en caso de error en la base
     */
    public function generarReporte() {
        try {
            $query = $this->db->connect()->prepare('CALL generarReporte(:id)');

            $query->execute(['id'=>$_SESSION['departamento']]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Funcion que busca reportes en la base de datos de un departamento
     * entre dos fechas indicadas, si las fechas son un 0 quiere decir que
     * se tiene que buscar un reporte de hace menos de 6 dias para asi saber
     * si se debe generar otro
     * @param $fechaInicio Date fecha de inicio para buscar
     * @param $fechaFinal Date fecha de fin para buscar
     * @param $departamento String nombre del departamento al que pertence el reporte
     * @return Exception en caso de error en la base
     */
    public function buscarReporte($fechaInicio,$fechaFinal,$departamento) {
        try {
            if ($fechaInicio == 0) {
                $query = $this->db->connect()->prepare('SELECT * 
                                                              FROM reporte 
                                                              WHERE departamento = :departamento AND fecha_creacion BETWEEN CURRENT_DATE-6 AND CURRENT_DATE');

                $query->execute(['departamento'=>$departamento]);
            }
            else {
                $query = $this->db->connect()->prepare('SELECT * 
                                                              FROM reporte 
                                                              WHERE departamento = :departamento AND fecha_creacion BETWEEN :fechaInicio AND :fechaFinal');

                $query->execute(['departamento'=>$departamento,
                                 'fechaInicio'=>$fechaInicio,
                                 'fechaFinal'=>$fechaFinal]);
            }
            return $query;
        }
        catch (PDOException $e) {
            return $e;
        }
    }
}