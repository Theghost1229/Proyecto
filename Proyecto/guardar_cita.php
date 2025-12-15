<?php
     session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
    include "mysqli_aux.php";

    $id_cliente = $_POST['id_cliente'];
    $id_barbero = $_POST['id_barbero'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO citas (id_cliente, id_barbero, hora, fecha) 
            VALUES ('$id_cliente', '$id_barbero', '$hora', '$fecha')";

    $nuevo_id = insertar($sql, "localhost", "barberias", "root", "n0m3l0");

    if ($nuevo_id) {
    
        header("Location: paginaP.php");
        exit();
        
    } else {
        echo "Error, no se pudo guardar la cita.";
        echo "<br>SQL Intentado: $sql";
    }
?>