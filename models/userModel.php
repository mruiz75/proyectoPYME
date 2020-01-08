<?php


class UserModel {

    private $cedula;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $correo;
    private $contrasena;
    private $telefono;
    private $departamento;
    private $posicion;

    function __construct($cedula,$nombre,$apellido1,$apellido2,$correo,$contrasena,$telefono,$departamento,$posicion) {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->telefono = $telefono;
        $this->departamento = $departamento;
        $this->posicion = $posicion;
    }

    /**
     * @return mixed
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * @return mixed
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @return false|string|null
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @return mixed
     */
    public function getPosicion()
    {
        return $this->posicion;
    }





}