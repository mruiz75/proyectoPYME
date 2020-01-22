<?php
    require_once 'conexion.php';

    $response = array();

    if(isset($_GET['apicall'])){
        switch($_GET['apicall']){

            case 'signup':
                if(isTheseParametersAvailable(array('cedula', 'nombre', 'apellido1', 'apellido2', 'email', 'contrasena', 'telefono', 'departamento', 'posicion'))){

                    if($_POST['departamento'] == 'Admin'){
                        $departamento = 1;
                    }elseif($_POST['departamento'] == 'Secretaria'){
                        $departamento = 2;
                    }elseif($_POST['departamento'] == 'Desarrollo'){
                        $departamento = 3;
                    }elseif($_POST['departamento'] == 'QA'){
                        $departamento = 4;
                    }elseif($_POST['departamento'] == 'HR'){
                        $departamento = 5;
                    }

                    if($_POST['posicion'] == 'CEO'){
                        $posicion = 0;
                    }elseif($_POST['posicion'] == 'Manager'){
                        $posicion = 1;
                    }elseif($_POST['posicion'] == 'Empleado'){
                        $posicion = 2;
                    }

                    $cedula = $_POST['cedula'];
                    $nombre = $_POST['nombre'];
                    $apellido1 = $_POST['apellido1'];
                    $apellido2 = $_POST['apellido2'];
                    $email = $_POST['email'];
                    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                    $telefono = $_POST['telefono'];
                    //$departamento = $_POST['departamento'];
                    //$posicion = $_POST['posicion'];
                }

                $stmt = $conn->prepare('SELECT cedula FROM usuario WHERE email = ?');
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();


                if($tmt->num_rows > 0){
                    $response['error'] = true;
                    $response['message'] = "User already registered";
                    $stmt->close();
                }else{
                    $stmt = $conn->prepare('INSERT INTO usuario (cedula, nombre, apellido1, apellido2, email, contrasena, telefono, departamento, posicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                    $stmt->bind_param("issssssii", $cedula, $nombre, $apellido1, $apellido2, $email, $contrasena, $telefono, $departamento, $posicion);
                
                    if($stmt->execute()){                        							
                        $stmt = $conn->prepare("SELECT cedula, nombre, apellido1, apellido2, email, contrasena, telefono, departamento, posicion FROM usuario WHERE cedula = ?"); 
                        $stmt->bind_param("i",$cedula);
                        $stmt->execute();
                        $stmt->bind_result($cedula, $nombre, $apellido1, $apellido2, $email, $contrasena, $telefono, $departamento, $posicion);
                        $stmt->fetch();
                        
                        $usuario = array(
                            'cedula'=>$cedula, 
                            'nombre'=>$nombre, 
                            'apellido1'=>$apellido1,
                            'apellido2'=>$apellido2,
                            'email'=>$email,
                            'contrasena'=>$contrasena,
                            'telefono'=> $telefono,
                            'departamento'=> $departamento,
                            'posicion'=> $posicion
                        );
                        
                        $stmt->close();
                        
                        $response['error'] = false; 
                        $response['message'] = 'Usuario registrado satisfactoriamente'; 
                        $response['usuario'] = $usuario; 
                    }
                }

            break;

            case 'login':
                if(isTheseParametersAvailable(array('email', 'contrasena'))){
                    //getting values 
                    $email = $_POST['email'];
                    //$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); 
                    $contrasenaLogin = $_POST['contrasena'];

                    //creating the query 
                    $stmt = $conn->prepare("SELECT usuario.cedula, usuario.nombre, usuario.apellido1, usuario.apellido2, usuario.correo, usuario.contrasena, usuario.telefono, usuario.departamento, usuario.posicion FROM usuario WHERE usuario.correo = ? AND usuario.posicion != 2");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    
                    $stmt->store_result();

                    $stmt->bind_result($cedula, $nombre, $apellido1, $apellido2, $email, $contrasena, $telefono, $departamento, $posicion);
                    $stmt->fetch();

                    //if the user exist with given credentials 
                    //if($stmt->num_rows > 0){
                    if(password_verify($contrasenaLogin, $contrasena)){
                        
                        //$stmt->bind_result($cedula, $nombre, $apellido1, $apellido2, $email, $contrasena, $telefono, $departamento, $posicion);
                        //$stmt->fetch();
                        
                        $usuario = array(
                            'cedula'=>$cedula, 
                            'nombre'=>$nombre, 
                            'apellido1'=>$apellido1,
                            'apellido2'=>$apellido2,
                            'email'=>$email,
                            'contrasena'=>$contrasena,
                            'telefono'=> $telefono,
                            'departamento'=> $departamento,
                            'posicion'=> $posicion
                        );
                        
                        
                        $response['error'] = false; 
                        $response['message'] = 'Login exitoso'; 
                        $response['usuario'] = $usuario;

                    }else{
                        //Si la contrasena no es la misma 
                        $response['error'] = true; 
                        $response['message'] = 'Email o contrasena invalidos.';
                    }
                }
            break;
            
            case 'reporte':
                $departamento = $_POST['departamento'];
                $fecha = '2020-01-19';

                try{
                    $stmtDepartamento = $conn->prepare('SELECT departamento.nombre FROM departamento WHERE departamento.id = ?');
                    $stmtDepartamento->bind_param("s", $departamento);
                    $stmtDepartamento->execute();
                    $stmtDepartamento->store_result();
                    
                    $stmtDepartamento->bind_result($nombreDepartamento);
                    $rowDeparmento = $stmtDepartamento->fetch();
                    
                    
                    $stmt = $conn->prepare('SELECT reporte.fecha_creacion, reporte.tareas_realizadas, reporte.tareas_no_realizadas, reporte.tiempo_tareas, reporte.tiempo_promedio_tareas, reporte.tiempo_libre, reporte.tiempo_promedio_libre, reporte.usuario_max_tareas, reporte.max_tareas, reporte.usuario_min_tareas, reporte.min_tareas FROM reporte WHERE DATE(reporte.fecha_creacion) = ? AND reporte.departamento = ?');
                    $stmt->bind_param("ss", $fecha, $nombreDepartamento);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($fechaCreacion, $tareasRealizadas, $tareasNoRealizadas, $tiempoTareas, $tiempoPromedioTareas, $tiempoLibre, $tiempoPromedioLibre, $usuarioMaxTareas, $maxTareas, $usuarioMinTareas, $minTareas);
                    $row = $stmt->fetch();
                    $reporte = array(
                        'fechaCreacion' => $fechaCreacion,
                        'tareasRealizadas' => $tareasRealizadas,
                        'tareasNoRealizadas' => $tareasNoRealizadas,
                        'tiempoTareas' => $tiempoTareas,
                        'tiempoPromedioTareas' => $tiempoPromedioTareas,
                        'tiempoLibre' => $tiempoLibre,
                        'tiempoPromedioLibre' => $tiempoPromedioLibre,
                        'usuarioMaxTareas' => $usuarioMaxTareas,
                        'maxTareas' => $maxTareas,
                        'usuarioMinTareas' => $usuarioMinTareas,
                        'minTareas' => $minTareas
                    );

                    $response['error'] = false; 
                    $response['message'] = 'Reporte cargado satisfactoriamente'; 
                    $response['reporte'] = $reporte; 
                
                }catch(PDOException $e){
                    $response['error'] = true; 
                    $response['message'] = 'Error al cargar el reporte';
                }
            break;

            case 'hojaTiempo':
                $cedula = $_POST['cedula'];
                $tareas = array();
                try{
                    $stmt = $conn->prepare('SELECT tarea.id, tarea.nombre, tarea.descripcion, tarea.fecha_limite, tarea.proyecto, tarea.hoja_tiempo, tarea.estado, tarea.lunes, tarea.martes, tarea.miercoles, tarea.jueves, tarea.viernes FROM usuario INNER JOIN hoja_de_tiempo ON usuario.cedula = hoja_de_tiempo.usuario INNER JOIN tarea ON hoja_de_tiempo.id = tarea.hoja_tiempo WHERE tarea.estado = 0 AND usuario.cedula = ?');
                    $stmt->bind_param("s", $cedula);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($id, $nombre, $descripcion, $fechaLimite, $proyecto, $hojaTiempo, $estado, $lunes, $martes, $miercoles, $jueves, $viernes);
                    while($row = $stmt->fetch()){
                        $tarea = array(
                            'id' => $id,
                            'nombre' => $nombre,
                            'descripcion' => $descripcion,
                            'fechaLimite' => $fechaLimite,
                            'proyecto' => $proyecto,
                            'hojaTiempo' => $hojaTiempo,
                            'estado' => $estado,
                            'lunes' => $lunes,
                            'martes' => $martes,
                            'miercoles' => $miercoles,
                            'jueves' => $jueves,
                            'viernes' => $viernes 
                        );
                        array_push($tareas, $tarea);
                    }
                    
                    $stmt->close();

                    // Recuperando información de la hoja de tiempo.
                    $stmt2 = $conn->prepare('SELECT hoja_de_tiempo.estado, hoja_de_tiempo.comentarios FROM hoja_de_tiempo INNER JOIN usuario ON usuario.cedula = hoja_de_tiempo.usuario WHERE usuario.cedula = ? AND hoja_de_tiempo.estado != 0');
                    $stmt2->bind_param("s", $cedula);
                    $stmt2->execute();
                    $stmt2->store_result();

                    $stmt->bind_result($estado, $comentarios);
                    $hoja = array(
                        'estado' => $estado,
                        'comentarios' => $comentarios
                    );
                    
                    $stmt2->close();
                    
                    $resultado = array('tareas' => $tareas, 'hoja' => $hoja);
                    $response['error'] = false; 
                    $response['message'] = 'Hoja de tiempo cargada exitosamente.'; 
                    $response['resultado'] = $resultado;
                    //$response['tareas'] = $tareas;
                    //$response['hoja'] = $hoja;

                }catch(PDOException $e){
                    $response['error'] = true; 
                    $response['message'] = 'Error al cargar la hoja de tiempo';
                }
            break;

            case 'bandejaEntrada':
                echo "bandeja de entrada";
            break;

            default:
                $response['error'] = true;
                $response['message'] = 'Operación Inválida';
        }

    }else{
        $response['error'] = true;
        $response['message'] = 'Llamada al API Inválida';
    }

    echo json_encode($response);

    function isTheseParametersAvailable($params){
        foreach($params as $param){
            if(!isset($_POST[$param])){
                return false;
            }
        }

        return true;
    }
?>