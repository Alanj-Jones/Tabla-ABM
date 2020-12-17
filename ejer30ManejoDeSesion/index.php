<?php
    session_start();

    if(!isset($_SESSION['sesion'])) {
        header('location:./login.html');
        exit();
    } else {
        header('location:./ingreso.php');
        exit();
    }
?>