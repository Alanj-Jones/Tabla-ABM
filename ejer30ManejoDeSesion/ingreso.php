<?php
    

    include("./app/datosConexion.php");
    $mysqli= new mysqli(SERVER,USUARIO,PASS,BASE);
    
    
    $user = $_POST["user"];
    $password = $_POST["password"];

    $encPassword =md5($password);

    $sentencia = $mysqli->prepare("select * from usuarios where user=? and password=?");
    $sentencia->bind_param('ss', $user, $encPassword);
    $sentencia->execute();

    if($sentencia->get_result()->num_rows){
        session_start();
        $cantidad = (int)file_get_contents('contador.txt');
        if(!isset($_SESSION["sessionId"])){
            $_SESSION["sessionId"] = session_id();
            $cantidad = $cantidad + 1;
            $contador = fopen("contador.txt","w+") or die("Fallo al abrir");
            file_put_contents('contador.txt', $cantidad);
            fclose($contador);
        }
        
        $aceptado = True;
        
        echo "<h1>Acceso Permitido</h1>";
        echo "<h2>Contador de logins: ". $cantidad . "<h2>";
        
        echo "<h2>Sus parametros de sesion son los siguientes</h2>";
        echo "<h3>ID de SESION: ". $_SESSION["sessionId"] . " </h3>";
        echo "<h3>Usuario: ". $user . " </h3>";
        echo "<h3>Contra sin encriptar: ". $password . " </h3>";
        echo "<h3>Contra con md5: ". $encPassword . " </h3>";
        
        echo "<p><button style='cursor: pointer;' onclick=\"location.href='app/indexABM.php'\">Ingrese a la Aplicacion</button></p>";
        echo "<p><button style='cursor: pointer;' onclick=\"location.href='./destroySession.php'\">Terminar Sesion</button></p>";
        
    } else {
        header("location:login.html");
    }
    $mysqli->close();
?>