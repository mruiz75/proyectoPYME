<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="localhost:8080/proyectoPYME/public/css/style.css">
    
    <title>Hoja de Tiempo</title>
</head>
<body>
    
    <div class="container">
        <?php require 'views/header.php'; ?>

        <h1 class="center" id="tituloPagina">HOJA DE TIEMPO</h1>
        <form action="<?php echo constant('URL');?>hojaTiempo/enviarRevision" method="POST">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead table-danger">
                        <tr>
                            <th scope="col" colspan="2">Horas libres</th>
                            <th scope="col">
                                <?php echo $this->lunes ?>
                            </th>
                            <th scope="col">
                                <?php echo $this->martes ?>
                            </th>
                            <th scope="col">
                                <?php echo $this->miercoles ?>
                            </th>
                            <th scope="col">
                                <?php echo $this->jueves ?>
                            </th>
                            <th scope="col">
                               <?php echo $this->viernes ?>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tareas</th>
                            <th scope="col">Lunes</th>
                            <th scope="col">Martes</th>
                            <th scope="col">Miercoles</th>
                            <th scope="col">Jueves</th>
                            <th scope="col">Viernes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            include_once 'models/tarea.php';
                            foreach($this->tareas as $row){
                                $tarea = new Tarea();
                                $tarea = $row;
                        ?>
                        <tr>
                            <td><?php echo $tarea->id; ?></td>
                            <td><b><?php echo $tarea->nombre; ?></b><p><?php echo $tarea->descripcion; ?></p></td>
                            <td><?php echo $tarea->lunes; ?></td>
                            <td><?php echo $tarea->martes; ?></td>
                            <td><?php echo $tarea->miercoles; ?></td>
                            <td><?php echo $tarea->jueves; ?></td>
                            <td><?php echo $tarea->viernes; ?></td>
                        </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>

            <div>
                <label class="comentariosHojaTiempo">COMENTARIOS:
                <?php 
                if(isset($hojaTiempo->comentarios)){
                    echo $hojaTiempo->comentarios;
                }else{
                    echo "No hay comentario por mostrar";
                }?>
                 </label>
            </div>
        </form>

    </div>

    <?php require 'views/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
</body>
</html>