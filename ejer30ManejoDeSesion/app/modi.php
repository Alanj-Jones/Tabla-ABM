<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }
?>
<?php   
    include("./datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);
    
    $IdTurno = $_POST['modiID'];
    $Matricula = $_POST['modiMatriculaDr'];
    $ApellidoDr = $_POST['modiApellidoDr'];
    $Especialidad = $_POST['modiEspecialidad'];
    $ApellidoPaciente = $_POST['modiApellidoPaciente'];
    $FechaTurno = $_POST['modiFechaTurno'];
    $Pdf = $_FILES['modiPDF'] ? file_get_contents($_FILES['modiPDF']['tmp_name']) : "";



    $sentencia = $mysqli->prepare("update turnomedico set Matricula=?,ApellidoDr=?,Especialidad=?,ApellidoPaciente=?,FechaTurno=? where IdTurno=?;");

    $sentencia->bind_param('issssi',$Matricula,$ApellidoDr,$Especialidad,$ApellidoPaciente,$FechaTurno,$IdTurno);

    if ($sentencia->execute()){
        echo "Objeto con:  <Br> ";
        echo "IdTurno: ". $IdTurno . "<Br>" ;
        echo "Matricula: ". $Matricula . "<Br>" ;
        echo "Especialidad: ". $Especialidad . "<Br>" ;
        echo "ApellidoPaciente: ". $ApellidoPaciente . "<Br>" ;
        echo "FechaTurno: ". $FechaTurno . "<Br>" ;
        echo "Fue Modificadio con exito!" ;
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