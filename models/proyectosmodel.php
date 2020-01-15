<?php
session_start();

class ProyectosModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($nombre,$descripcion,$administrador,$departamento) {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO proyecto(nombre,descripcion,departamento,administrador)
                                                          VALUES (:nombre,:descripcion,:departamento,:administrador)');

            return $query->execute(['nombre' => $nombre,
                                    'descripcion' => $descripcion,
                                    'departamento' => $departamento,
                                    'administrador' => $administrador]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function getCedulaFromUser($nombreCompleto) {
        try {
            $query = $this->db->connect()->prepare('SELECT cedula 
                                                              FROM usuario
                                                              WHERE nombre = :nombre AND apellido1 = :apellido1 AND apellido2 = :apellido2');

            $query->execute(['nombre'=>$nombreCompleto[0],
                             'apellido1'=>$nombreCompleto[1],
                             'apellido2'=>$nombreCompleto[2]]);

            $result = $query->fetch();

            return $result['cedula'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function cargarUsuarios() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre,apellido1,apellido2 
                                                          FROM usuario');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre,apellido1,apellido2 
                                                          FROM usuario
                                                          WHERE departamento = :departamento');

                $query->execute(['departamento' => $_SESSION['departamento']]);
            }

            $usuarios = [];
            $usuario = "";

            while ($registro = $query->fetch()) {
                $usuario = $registro['nombre'] . " " . $registro['apellido1'] . " " . $registro['apellido2'];
                array_push($usuarios, $usuario);
            }

            return $usuarios;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function cargarProyectos() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                            FROM proyecto');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                            FROM proyecto 
                                                            WHERE departamento = :departamento');

                $query->execute(['departamento'=>$_SESSION['departamento']]);
            }

           $proyectos = [];

           while ($result = $query->fetch()) {
               array_push($proyectos,$result['nombre']);
           }

           return $proyectos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function borrar($nombre) {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM proyecto
                                                              WHERE nombre = :nombre');

            $query->execute(['nombre'=>$nombre]);
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function cargarDepartamentos() {
        try {
            if ($_SESSION['posicion'] == 0) {
                $query = $this->db->connect()->prepare('SELECT nombre FROM departamento');

                $query->execute();
            }
            else {
                $query = $this->db->connect()->prepare('SELECT nombre 
                                                                FROM departamento
                                                                WHERE id = :id');

                $query->execute(['id'=>$_SESSION['departamento']]);
            }

            $departamentos = [];

            while ($registro=$query->fetch()){
                array_push($departamentos,$registro['nombre']);
            }

            return $departamentos;
        }
        catch (PDOException $e) {
            return $e;
        }
    }

    public function getIdFromDepartamento($nombre) {
        try {
            $query = $this->db->connect()->prepare('SELECT id FROM departamento WHERE nombre = :nombre');

            $query->execute(['nombre'=>$nombre]);

            $registro = $query->fetch();

            return $registro['id'];
        }
        catch (PDOException $e) {
            return $e;
        }
    }

}