<?php

/**
 * Clase que le da estructura al funcionamiento de las vistas.
 */

class View{

    function __construct(){
        //echo "<p>Vista principal</p>";
    }

    function render($nombre){
        require 'views/' . $nombre . '.php';
    }

}
?>