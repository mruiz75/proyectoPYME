<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <title>Gestion de tareas</title>
</head>
<body>

<div class="container">
    <?php require 'views/header.php'; ?>

    <h1 class="center">Crear Proyecto</h1>
    <form action="<?php echo constant('URL'); ?>proyectos/insertar" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Descripcion</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="descripcion" placeholder="Descripcion" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Administrador</label>
            <div class="col-sm-10">
                <select class="form-control" name="administrador">
                    <?php
                    foreach ($this->usuarios as &$usuario) {
                        echo "<option>".$usuario."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Departamento</label>
            <div class="col-sm-10">
                <select class="form-control" name="departamento">
                    <?php
                    foreach ($this->departamentos as &$departamento) {
                        echo "<option>".$departamento."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Crear proyecto</button>
            </div>
        </div>
    </form>

    <h1 class="center">Borrar Proyecto</h1>
    <form action="<?php echo constant('URL'); ?>proyectos/borrar" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
                <select class="form-control" name="proyecto">
                    <?php

                    foreach ($this->proyectos as &$proyecto) {
                        echo "<option>".$proyecto."</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Borrar Proyecto</button>
            </div>
        </div>
    </form>

    <?php
    if (isset($this->message)) {
        echo $this->message;
    }
    ?>

</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>