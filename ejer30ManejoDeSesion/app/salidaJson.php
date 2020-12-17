<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }

    include("./datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);

    if (isset($_GET['orden'])){
        $orden = $_GET['orden'];
    }

    $filtroIdTurno= $_GET['filtroIdTurno'];
    $filtroApellidoDr = $_GET['filtroApellidoDr'];
    $filtroMatricula = $_GET['filtroMatricula'];
    $filtroEspecialidad = $_GET['filtroEspecialidad'];
    $filtroApellidoPaciente = $_GET['filtroApellidoPaciente'];
    $filtroFechaTurno = $_GET['filtroFechaTurno'];

    $sql = "select * from turnomedico where ";
    $sql = $sql . "IdTurno like '%".$filtroIdTurno."%' and ";
    $sql = $sql . "ApellidoDr like '%".$filtroApellidoDr."%' and ";
    $sql = $sql . "Matricula like '%".$filtroMatricula."%' and ";
    $sql = $sql . "Especialidad like '%".$filtroEspecialidad."%' and ";
    $sql = $sql . "ApellidoPaciente like '%".$filtroApellidoPaciente."%' and ";
    $sql = $sql . "FechaTurno like '%".$filtroFechaTurno."%'";

    $sql = $sql . " order by " . $orden;

    if (!($resultado = $mysqli->query($sql))){

        die();
    }

    $resultadoCuentaRegistros = $resultado->num_rows;

    $turnos=[];

    while( $fila=$resultado->fetch_assoc()){
        $objTurno = new stdClass();
        $objTurno->IdTurno = $fila['IdTurno'];
        $objTurno->Matricula = $fila['Matricula'];
        $objTurno->ApellidoDr = $fila['ApellidoDr'];
        $objTurno->Especialidad = $fila['Especialidad'];
        $objTurno->ApellidoPaciente = $fila['ApellidoPaciente'];
        $objTurno->FechaTurno = $fila['FechaTurno']; 
        $objTurno->Pdf =  base64_encode($fila['Pdf']);      

        array_push($turnos,$objTurno);
    }

    $objTurnos = new stdClass();
    $objTurnos->turnos = $turnos;
    $objTurnos->cuenta = $resultadoCuentaRegistros;

    $salidaJson = json_encode($objTurnos);
    $mysqli->close();
    echo $salidaJson;

?>