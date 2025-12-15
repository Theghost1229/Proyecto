<?php
    include "mysqli_aux.php";

    // 1. CARGAR LISTA DE CITAS (CON EL NOMBRE DEL CLIENTE)
    // Usamos INNER JOIN para unir 'citas' con 'clientes' usando el 'id_cliente' que tienen en común.
    // Así obtenemos:
    // - citas.id_cita (Para saber qué borrar/actualizar)
    // - clientes.nombre_cliente (Para mostrar en la lista y que se entienda)
    
    $sql_citas = "SELECT citas.id_cita, clientes.nombre_cliente 
                  FROM citas 
                  INNER JOIN clientes ON citas.id_cliente = clientes.id_cliente";
                  
    $lista_citas = seleccionar($sql_citas, "localhost", "barberias", "root", "n0m3l0");
    $sql_barberos = "SELECT id_barbero, nombre_barbero FROM barberos";
    $lista_barberos = seleccionar($sql_barberos, "localhost", "barberias", "root", "n0m3l0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cita - Barberstop</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; }
        .top-header { width: 100%; height: 60px; background-color: #555; color: white; border-collapse: collapse; }
        .header-left { padding-left: 20px; font-size: 18px; font-weight: bold; width: 20%; }
        .header-center { text-align: center; font-size: 18px; font-weight: bold; width: 60%; }
        .header-right { text-align: right; padding-right: 20px; width: 20%; }
        .main-container { width: 100%; height: calc(100vh - 60px); vertical-align: top; padding-top: 40px; }
        .form-label { font-weight: bold; color: #333; display: block; margin-bottom: 8px; font-size: 14px; }
        .form-input, .form-select { width: 100%; padding: 12px; margin-bottom: 25px; border: 1px solid #ddd; border-radius: 5px; background-color: #f4f6f8; font-size: 14px; box-sizing: border-box; color: #555; }
        .btn-cancel { background-color: #e0e0e0; color: #333; border: none; padding: 12px 40px; border-radius: 5px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-save { background-color: #2962ff; color: white; border: none; padding: 12px 40px; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-save:hover { background-color: #0d47a1; }
        .logo-bottom { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

    <table class="top-header">
        <tr>
            <td class="header-left">Barberstop</td>
            <td class="header-center">Editar cita</td>
            <td class="header-right">👤</td>
        </tr>
    </table>

    <table class="main-container">
        <tr>
            <td align="center">
                
                <div style="width: 800px; background-color: white; padding: 40px; text-align: left; border-radius: 8px;">
                    
                    <form action="guardar_actualizacion.php" method="POST">
                        
                        <table width="100%" border="0" cellspacing="10">
                            <tr>
                                <td width="50%">
                                    <label class="form-label">Nombre del cliente (Seleccione Cita)</label>
                                    
                                    <select name="id_cita" class="form-select" required>
                                        <option value="">Seleccione la cita a actualizar</option>
                                        <?php foreach($lista_citas as $cita): ?>
                                            <option value="<?php echo $cita[0]; ?>">
                                                <?php echo "Cita #" . $cita[0] . " - " . $cita[1]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </td>
                                <td width="50%">
                                    <label class="form-label">Barbero</label>
                                    <select name="id_barbero" class="form-select" required>
                                        <option value="">Seleccione nuevo barbero</option>
                                        <?php foreach($lista_barberos as $barbero): ?>
                                            <option value="<?php echo $barbero[0]; ?>">
                                                <?php echo $barbero[1]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><h3 style="margin: 10px 0; color: #333;">Detalles de la Cita</h3></td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="form-label">Fecha de la Cita:</label>
                                    <input type="date" name="fecha" class="form-input" required>
                                </td>
                                <td>
                                    <label class="form-label">Hora de la Cita:</label>
                                    <select name="hora" class="form-select" required>
                                        <option value="">Seleccione nueva hora</option>
                                        <?php 
                                            for($i=1; $i<=20; $i++) {
                                                $hora_fmt = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";
                                                echo "<option value='$hora_fmt'>$hora_fmt</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr><td height="40"></td></tr>

                            <tr>
                                <td align="left">
                                    <a href="paginaP.php" class="btn-cancel">Cancelar</a>
                                </td>
                                <td align="right">
                                    <button type="submit" class="btn-save">Guardar Cambios</button>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <div class="logo-bottom">
                        <img src="logo.png" width="60" alt="Logo">
                    </div>

                </div>

            </td>
        </tr>
    </table>

</body>
</html>