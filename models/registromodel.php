<?php

/**
 * Class RegistroModel
 * Clase para el modelo del controller de registro
 * se usa para la funcionalidad de cargar los departamentos
 * en la pagina de registro
 */
class RegistroModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function cargarDepartamentos() {

        $query = $this->db->connect()->prepare('SELECT * FROM departamento');

        $query->execute();

        $nombres = [];

        while ($result=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($nombres,$result['nombre']);
        }

        return $nombres;
    }

    public function getDepartamentoId($nombre) {

        $query = $this->db->connect()->prepare('SELECT id FROM departamento WHERE nombre = :nombre');

        $query->execute(['nombre'=>$nombre]);

        $registro = $query->fetch(PDO::FETCH_ASSOC);

        return $registro['id'];
    }

}