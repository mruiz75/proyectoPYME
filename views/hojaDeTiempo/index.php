<?php 
	
	//session_start();
	// if(!isset($_SESSION['email'])){
	// 	header('location:login.php');
	// }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>Home Page</title>
 	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="public/css/home.css">
 </head>
 <body>

	<nav class="navbar navbar-default">
  		<div class="container">
    	<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
     			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
     			</button>
      		<a class="navbar-brand btn disabled" href="#">LOGO</a>
    		</div>

    	<!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      		<ul class="nav navbar-nav">
      		  <li class="active"><a href="#">Hoja de Tiempo</a></li>
 			    	<li><a href="../bandejaEntrada/index.php">Bandeja de Entrada</a></li>
 			    	<li><a href="../gestionUsuarios/index.php">Gestión de Usuarios</a></li>
 			    	<li><a href="../gestionTareas/index.php">Gestión de Tareas</a></li>
 			    	<li><a href="../gestionProyectos/index.php">Gestión de Proyectos</a></li>
 			    	<li><a href="../reportes/index.php">Reportes</a></li>
      		</ul>
      		<ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="btn disabled"><?php echo $_SESSION['correo'] ?></a></li>
        		<li><a href="logout.php"><i class="fas fa-user"></i> Log Out</a></li>
      		</ul>
    		</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
	</nav>

    <div class="container">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Agregar tarea
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="?tarea=Tarea1<?php echo ",".$_GET['tarea']?>">Tarea1</a>
                <a class="dropdown-item" href="?tarea=Tarea2<?php echo ",".$_GET['tarea']?>">Tarea2</a>
                <a class="dropdown-item" href="?tarea=Tarea3<?php echo ",".$_GET['tarea']?>">Tarea3</a>
            </div>
        </div><br>

    	 <table class="table">
        <thead>
          <tr class="danger">
            <th>Tareas</th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </tr>
        </thead>

        <tbody>
                <?php
                if ($_GET['tarea'] != null && $_GET['tarea'] != "") {
                    $tareas = explode(",",$_GET['tarea']);

                    foreach ($tareas as $tarea) {
                        if ($tarea != '') {
                            echo "<tr>
                                  <td>" . $tarea . "</td>
                                  <td><input type=\"text\" name=\"tiempo\"></td>
                                  <td><input type=\"text\" name=\"tiempo\"></td>
                                  <td><input type=\"text\" name=\"tiempo\"></td>
                                  <td><input type=\"text\" name=\"tiempo\"></td>
                                  <td><input type=\"text\" name=\"tiempo\"></td>
                                  </tr>";
                        }
                    }
                }
                ?>
        </tbody>
       </table>
     <input type="submit" value="Solicitar Revisión">
    </div>

	 <script   src="http://code.jquery.com/jquery-3.4.1.js"   integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="   crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
 </body>
 </html>