package com.example.pruebaapp;

/*
 URLs que el app se encarga de conseguir dentro del servidor. En este caso se usa un archivo API fijo
 y se accede a un switch con distintos casos para cada llamado. Cada string contiene el nombre del caso
 al final.
*/
public class URLs {

    private static final String ROOT_URL = "http://192.168.64.2/pruebaApp/api.php?apicall=";

    public static final String URL_REGISTER = ROOT_URL + "signup";
    public static final String URL_LOGIN = ROOT_URL + "login";
    public static final String URL_HOJATIEMPO = ROOT_URL + "hojaTiempo";
    public static final String URL_REPORTE = ROOT_URL + "reporte";
}
