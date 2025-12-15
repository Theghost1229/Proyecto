<?php
// 1. Incluimos tu archivo de conexión
include "mysqli_aux.php";

// 2. Verificamos que venga un ID en la URL
if (isset($_GET['id'])) {
    
    // Recibimos el ID de la cita a borrar
    $id = $_GET['id'];

    // 3. Preparamos la consulta SQL
    // Nota: La tabla se llama 'citas' y la columna 'id_cita' (según tu imagen)
    $sql = "DELETE FROM citas WHERE id_cita = $id";

    // 4. Ejecutamos la consulta
    // Asegúrate de usar los datos correctos: "barberias", "root", "root"
    $exito = ejecutar($sql, "localhost", "barberias", "root", "n0m3l0");

    if ($exito) {
        // SI SE BORRÓ BIEN: Redirigimos de vuelta a la Agenda automáticamente
        header("Location: paginaP.php");
        exit();
    } else {
        // SI HUBO ERROR: Mostramos mensaje
        echo "Error, no se pudo borrar la cita con ID $id.";
    }

} else {
    echo "No se especificó ninguna cita para borrar.";
}
?>