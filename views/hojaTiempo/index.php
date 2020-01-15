<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="localhost:8080/proyectoPYME/public/css/style.css">
    
    <title>Hoja de Tiempo</title>

    <script type="text/javascript">
        function setHora(checkbox, dia) {
            obj = document.getElementById(checkbox);
            input = document.getElementById(dia);

            if (obj.checked) {
                input.value = "08:00";
            }
        }
    </script>
</head>
<body>
    
    <div class="container">
        <?php require 'views/header.php'; ?>

        <h1 class="center" id="tituloPagina">HOJA DE TIEMPO</h1>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Agregar tarea
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                foreach ($this->tareasMostrar as &$tarea) {
                    echo "<a class='dropdown-item' href='".constant('URL')."tareas/asignar/".$tarea."/".$this->id."'>".$tarea."</a>";
                }
                ?>
            </div>
        </div>
        <br>
        <form action="<?php echo constant('URL');?>hojaTiempo/enviarRevision" method="POST">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead table-danger">
                        <tr>
                            <th scope="col" colspan="2">Horas libres</th>
                            <th scope="col">
                                <input type="checkbox" id="clunes" onclick="setHora('clunes','lunes')">Todo el dia</input><br>
                                <input name="libre[]" id="lunes" type="time" class="inputHora" value="<?php echo $this->lunes ?>">
                            </th>
                            <th scope="col">
                                <input type="checkbox" id="cmartes" onclick="setHora('cmartes','martes')">Todo el dia</input><br>
                                <input name="libre[]" id="martes" type="time" class="inputHora" value="<?php echo $this->martes ?>">
                            </th>
                            <th scope="col">
                                <input type="checkbox" id="cmiercoles" onclick="setHora('cmiercoles','miercoles')">Todo el dia</input><br>
                                <input name="libre[]" id="miercoles" type="time" class="inputHora" value="<?php echo $this->miercoles ?>">
                            </th>
                            <th scope="col">
                                <input type="checkbox" id="cjueves" onclick="setHora('cjueves','jueves')">Todo el dia</input><br>
                                <input name="libre[]" id="jueves" type="time" class="inputHora" value="<?php echo $this->jueves ?>">
                            </th>
                            <th scope="col">
                                <input type="checkbox" id="cviernes" onclick="setHora('cviernes','viernes')">Todo el dia</input><br>
                                <input name="libre[]" id="viernes" type="time" class="inputHora" value="<?php echo $this->viernes ?>">
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" >ID</th>
                            <th scope="col">Tareas</th>
                            <th scope="col">Lunes</th>
                            <th scope="col">Martes</th>
                            <th scope="col">Miercoles</th>
                            <th scope="col">Jueves</th>
                            <th scope="col">Viernes</th>
                        </tr>
                    <tbody>
                        <?php 
                            include_once 'models/tarea.php';
                            foreach($this->tareas as $row){
                                $tarea = new Tarea();
                                $tarea = $row;
                        ?>
                        <tr>
                            <td><input id="idTarea" name="id[]" type="text" value=<?php echo $tarea->id; ?> readonly="readonly"></td>
                            <td><b><?php echo $tarea->nombre; ?></b><p><?php echo $tarea->descripcion; ?></p></td>
                            <td><input name="lunes[]" type="time" class="inputHora" value=<?php echo $tarea->lunes; ?>></td>
                            <td><input name="martes[]" type="time" class="inputHora" value=<?php echo $tarea->martes; ?>></td>
                            <td><input name="miercoles[]" type="time" class="inputHora" value=<?php echo $tarea->miercoles; ?>></td>
                            <td><input name="jueves[]" type="time" class="inputHora" value=<?php echo $tarea->jueves; ?>></td>
                            <td><input name="viernes[]" type="time" class="inputHora" value=<?php echo $tarea->viernes; ?>></td>
                        </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>

            <div>
                <label class="comentariosHojaTiempo">COMENTARIOS:
                <?php 
                if(isset($this->comentarios)){
                    echo $this->comentarios;
                }else{
                    echo "No hay comentario por mostrar";
                }?>
                 </label>
                <input type="submit" class="btn btn-outline-success float-right" value="Enviar a Revisión">
            </div>
        </form>

    </div>

    <?php require 'views/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
</body>
</html>