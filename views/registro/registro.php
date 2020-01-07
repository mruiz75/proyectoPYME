<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registro</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
</head>
<body>
	<div class="container">
		<div class="login-box">
			<div class="row">
				<div class="col-lg-12 inicio-box">
					<h2>Registro de usuario</h2>
					<form action="<?php echo constant('URL'); ?>registro" method="post">
                        <?php
                            if(isset($this->message)){
                                echo $this->message;
                            }
                        ?>
						<div class="form-group">
							<label>Cedula</label>
							<input type="text" name="cedula" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" name="nombre" class="form-control" required>
						</div>
                        <div class="form-group">
                            <label>Apellido1</label>
                            <input type="text" name="apellido1" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido2</label>
                            <input type="text" name="apellido2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="contrasena" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
						<button type="submit" class="btn btn-primary">Registrarse</button>
					</form>
                    <a class="nav-link" href="<?php echo constant('URL'); ?>index">Volver</a>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
