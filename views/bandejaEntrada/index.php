<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="proyectoPYME/public/css/style.css">
    
    <title>Bandeja de Entrada</title>
</head>
<body>
    
    <div class="container">
        <?php require 'views/header.php'; ?>

        <h1 class="center" id="tituloPagina">BANDEJA DE ENTRADA</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead table-primary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha Finalizacion</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            include_once 'models/hojaTiempo.php';
                            foreach($this->hojas as $row){
                                $hoja = new HojaTiempo();
                                $hoja = $row;
                        ?>
                        <form action="<?php echo constant('URL');?>bandejaEntrada/abrir" method="POST">
                            <tr>
                                <td><input type="text" name="hojaId" value=<?php echo $hoja->id; ?> readonly="readonly"></td>
                                <td><b><?php echo $hoja->nombre; ?></b><p><?php echo " " . $hoja->apellido1; ?></p></td>
                                <td><?php echo $hoja->fecha_finalizacion; ?></td>
                                <td><input type="submit" class="btn btn-outline-info" value="Abrir"></td>
                            </tr>
                        </form>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>



    </div>

    <?php require 'views/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>