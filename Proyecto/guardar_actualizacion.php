<?php
 session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
    include "mysqli_aux.php";
    $id_cita    = $_POST['id_cita'];     
    $id_barbero = $_POST['id_barbero'];  
    $fecha      = $_POST['fecha'];       
    $hora       = $_POST['hora'];        

    $sql = "UPDATE citas SET 
                id_barbero = '$id_barbero', 
                fecha = '$fecha', 
                hora = '$hora' 
            WHERE id_cita = $id_cita";

    $exito = ejecutar($sql, "localhost", "barberias", "root", "n0m3l0");

    if ($exito) {
        header("Location: paginaP.php");
        exit();
    } else {
        echo "Error, no se pudo actualizar la cita con ID $id_cita.";
        echo "<br>SQL: $sql";
        echo '<br><a href="actualizar_cita.php">Volver a intentar</a>';
    }
?>