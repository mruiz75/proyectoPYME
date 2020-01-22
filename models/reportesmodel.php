<?php

session_start();
class ReportesModel extends Model {

    function __construct() {
        parent::__construct();
    }

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

    public function generarReporte() {
        try {
            $query = $this->db->connect()->prepare('CALL generarReporte(:id)');

            $query->execute(['id'=>$_SESSION['departamento']]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

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