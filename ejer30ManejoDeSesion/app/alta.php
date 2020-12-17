<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }

    include("./datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);


    $IdTurno = $_POST['altaID'];
    $Matricula = $_POST['altaMatriculaDr'];
    $ApellidoDr = $_POST['altaApellidoDr'];
    $Especialidad = $_POST['altaEspecialidad'];
    $ApellidoPaciente = $_POST['altaApellidoPaciente'];
    $FechaTurno = $_POST['altaFechaTurno'];
    $Pdf = $_FILES['Pdf'] ? file_get_contents($_FILES['Pdf']['tmp_name']) : "";

    
    $sentencia = $mysqli->prepare('insert into turnomedico (IdTurno,Matricula,ApellidoDr,Especialidad,ApellidoPaciente,FechaTurno)
                                    values(?,?,?,?,?,?)');

    $sentencia->bind_param('iissss',$IdTurno,$Matricula,$ApellidoDr,$Especialidad,$ApellidoPaciente,$FechaTurno);

    if ($sentencia->execute()){
        echo "Objeto con:  <Br> ";
        echo "IdTurno: ". $IdTurno . "<Br>" ;
        echo "Matricula: ". $Matricula . "<Br>" ;
        echo "Especialidad: ". $Especialidad . "<Br>" ;
        echo "ApellidoPaciente: ". $ApellidoPaciente . "<Br>" ;
        echo "FechaTurno: ". $FechaTurno . "<Br>" ;
        echo "Fue creado con exito!" ;
    }else{
        echo "Ha ocurrido un error!";
    }

    $sentenciaPDF = $mysqli->prepare("update turnomedico set "
                        .  " Pdf=? "
                        . " where IdTurno=? ");

    $sentenciaPDF->bind_param('si', $Pdf, $IdTurno);
    
    if ($sentenciaPDF->execute()){
        echo "<br>PDF subido";
    } else {
        echo "<br> Error en la subida del PDF";
    }

    $mysqli->close();
    
 
 ?>