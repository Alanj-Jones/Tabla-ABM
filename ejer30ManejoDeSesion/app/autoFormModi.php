<?php    
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }


    
    include("./datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);

     //Intento de que se ponga automaticamente los valores en la modificacion
     $IdTurno = $_GET['IdTurno'];

     $sql = "select * from turnomedico where IdTurno = ". $IdTurno;
 
     if (!($resultado = $mysqli->query($sql))){
 
         die();
     }
 
     $turno=[];

     while($fila=$resultado->fetch_assoc()){
        $objTurno = new stdClass();
        $objTurno->IdTurno = $fila['IdTurno'];
        $objTurno->Matricula = $fila['Matricula'];
        $objTurno->ApellidoDr = $fila['ApellidoDr'];
        $objTurno->Especialidad = $fila['Especialidad'];
        $objTurno->ApellidoPaciente = $fila['ApellidoPaciente'];
        $objTurno->FechaTurno = $fila['FechaTurno'];        

        array_push($turno,$objTurno);
    }
    
     $mysqli->close();
     $salidaJson = json_encode($objTurno);
     
     
     echo $salidaJson;


?>    