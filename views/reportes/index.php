<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <title>Gestion de reportes</title>
</head>
<body>
    <div class="container">
        <?php require 'views/header.php'; ?>

        <a class="btn btn-primary" href="<?php echo constant('URL'); ?>reportes/generar">Generar reporte semanal</a>

        <h1 class="center">Buscar reportes</h1>
        <form action="<?php echo constant('URL'); ?>reportes/buscar" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fecha desde</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="fechaDesde" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fecha hasta</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="fechaHasta" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <?php
            if (isset($this->query)) {?>
                <table class="table">
                    <thead class="thead table-primary">
                    <tr>
                        <th scope="col">Fecha de creacion</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Tareas realizadas</th>
                        <th scope="col">Tareas sin realizar</th>
                        <th scope="col">Tiempo invertido en tareas</th>
                        <th scope="col">Tiempo promedio por tarea</th>
                        <th scope="col">Tiempo libre tomado</th>
                        <th scope="col">Tiempo promedio libre por dia</th>
                        <th scope="col">Usuario con mas tareas</th>
                        <th scope="col">Usuario con menos tareas</th>
                    </tr>
                    </thead>
        <?php
                while($registro=$this->query->fetch()) {?>
                    <tr>
                        <td><?php echo $registro['fecha_creacion']?></td>
                        <td><?php echo $registro['departamento']?></td>
                        <td><?php echo $registro['tareas_realizadas']?></td>
                        <td><?php echo $registro['tareas_no_realizadas']?></td>
                        <td><?php echo $registro['tiempo_tareas']?></td>
                        <td><?php echo $registro['tiempo_promedio_tarea']?></td>
                        <td><?php echo $registro['tiempo_libre']?></td>
                        <td><?php echo $registro['tiempo_promedio_libre']?></td>
                        <td><b><?php echo $registro['usuario_max_tareas'] ?></b><p>Tareas: <?php echo $registro['max_tareas'] ?></p></td>
                        <td><b><?php echo $registro['usuario_min_tareas'] ?></b><p>Tareas: <?php echo $registro['min_tareas'] ?></p></td>
        <?php
                }
            }

            if (isset($this->mensaje)) {
                echo $this->mensaje;
            }
        ?>


    </div>

    <?php require 'views/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>