<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }

    include("./datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);  

    $IdTurno = $_GET['IdTurno'];
    
    $sql = "delete from turnomedico where IdTurno = ". $IdTurno;
    $resultado= $mysqli->query($sql);

    if ($resultado){
        echo "Turno con ID: " . $IdTurno . " ha sido eliminado";
    } else {
        echo "Operacion no exitosa";
    }
    $mysqli->close();



?>