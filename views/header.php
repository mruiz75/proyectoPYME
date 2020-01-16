<!-- Header que contiene la barra de navegación entre secciones de la aplicación web -->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="public/css/footer.css">
    
    <title>Colors</title>
</head>
<body>
    <?php 
        if(!isset($_SESSION['nombre'])){
            session_start();
        }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand disabled" href="<?php echo constant('URL'); ?>inicio" aria-disabled="true">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo constant('URL'); ?>hojaTiempo">Hoja de Tiempo</a>
                </li>
                <?php
                    if ($_SESSION['posicion'] != 2) {?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('URL'); ?>bandejaEntrada">Bandeja de Entrada</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('URL'); ?>proyectos">Gestion de Proyectos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('URL'); ?>usuarios">Gestion de Usuarios</a>
                        </li>
                <?php
                    }
                    if ($_SESSION['posicion'] != 2 || $_SESSION['administrador'] > 0) {?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('URL'); ?>tareas">Gestion de Tareas</a>
                        </li>
                <?php
                    }
                    ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reportes</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <label for=""><h3 class="center"><?php //echo $this->user->getNombre(); ?></h3>
    </label> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo constant('URL'); ?>logout">LOGOUT</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>