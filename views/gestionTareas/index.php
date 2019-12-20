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
	<link rel="stylesheet" type="text/css" href="home.css">
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
      		  <li><a href="<?php echo constant('URL'); ?>main">Hoja de Tiempo</a></li>
 			    	<li><a href="<?php echo constant('URL'); ?>bandejaEntrada">Bandeja de Entrada</a></li>
 			    	<li><a href="<?php echo constant('URL'); ?>gestionUsuarios">Gestión de Usuarios</a></li> 
 			    	<li class="active"><a href="#">Gestión de Tareas</a></li>
 			    	<li><a href="<?php echo constant('URL'); ?>gestionProyectos">Gestión de Proyectos</a></li> 
 			    	<li><a href="<?php echo constant('URL'); ?>reportes">Reportes</a></li>
      		</ul>
      		<ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="btn disabled"><?php echo $_SESSION['correo'] ?></a></li>
        		<li><a href="logout.php"><i class="fas fa-user"></i> Log Out</a></li>
      		</ul>
    		</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
	</nav>

	 <table>
    <thead>
      <tr>
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
       ?>
    </tbody>
   </table>
	 <script   src="http://code.jquery.com/jquery-3.4.1.js"   integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="   crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
 </body>
 </html>