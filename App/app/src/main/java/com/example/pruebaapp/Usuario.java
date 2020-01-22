package com.example.pruebaapp;

//Clase para generar objetos de tipo Usuario
public class Usuario {

    private int cedula;
    private String nombre, apellido1, apellido2, email, telefono, departamento, posicion;

    public Usuario(int cedula, String nombre, String apellido1, String apellido2, String email, String telefono, String departamento, String posicion) {
        this.cedula = cedula;
        this.nombre = nombre;
        this.apellido1 = apellido1;
        this.apellido2 = apellido2;
        this.email = email;
        this.telefono = telefono;
        this.departamento = departamento;
        this.posicion = posicion;
    }

    public int getCedula() {
        return cedula;
    }

    public String getNombre() {
        return nombre;
    }

    public String getApellido1() {
        return apellido1;
    }

    public String getApellido2() {
        return apellido2;
    }

    public String getEmail() {
        return email;
    }

    public String getTelefono() {
        return telefono;
    }

    public String getDepartamento() {
        return departamento;
    }

    public String getPosicion() {
        return posicion;
    }
}
