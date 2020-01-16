<?php

/**
 * Clase que le da estructura al funcionamiento de los modelos al crear un nuevo objeto de tipo Database.
 */

class Model{

    function __construct(){
        //echo "<p>Modelo principal</p>";
        $this->db = new Database();
    }
}
?>