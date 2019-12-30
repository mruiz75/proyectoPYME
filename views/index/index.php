<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
	<div class="container">
		<div class="login-box">
			<div class="row">
				<div class="col-lg-12 inicio-box">
					<h2>Inicio</h2>
					<form action="" method="post">
						<?php
							if(isset($this->errorLogin)){
								echo $this->errorLogin;
							}
						?>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="correo" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Contrasena</label>
							<input type="password" name="contrasena" class="form-control" required>
						</div>
						<button type="submit" class="btn btn-primary">Log in</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>