<?php
    session_start();
    if(!isset($_SESSION['sessionId'])) {
        header('location:./../login.html');
        exit();
    }

$especialidades = [];

array_push($especialidades,"Pediatria");
array_push($especialidades,"Oftalmologo");
array_push($especialidades,"Psicologia");
array_push($especialidades,"Urologo");
array_push($especialidades,"Dermatologo");

$salida = new stdClass;
$salida->espec = $especialidades;

$respuesta = json_encode($salida);

echo $respuesta;

?>