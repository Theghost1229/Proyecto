<?php
     session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
    include "mysqli_aux.php";
    $sql_clientes = "SELECT id_cliente, nombre_cliente FROM clientes";
    $lista_clientes = seleccionar($sql_clientes, "localhost", "barberias", "root", "n0m3l0");
    $sql_barberos = "SELECT id_barbero, nombre_barbero FROM barberos";
    $lista_barberos = seleccionar($sql_barberos, "localhost", "barberias", "root", "n0m3l0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Programar Nueva Cita - Barberstop</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9; 
        }

        .top-header {
            width: 100%;
            height: 60px;
            background-color: #555555;
            color: white;
            border-collapse: collapse;
        }
        
        .header-left {
            padding-left: 20px;
            font-size: 18px;
            font-weight: bold;
            width: 20%;
        }

        .header-center {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            width: 60%;
        }

        .header-right {
            text-align: right;
            padding-right: 20px;
            width: 20%;
        }

        .main-container {
            width: 100%;
            height: calc(100vh - 60px); 
            vertical-align: top;
            padding-top: 40px;
        }

        .form-wrapper-table {
            width: 800px;
            margin: 0 auto; 
            background-color: white;
            padding: 40px; 
            border-radius: 8px; 
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-label {
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px;
            margin-bottom: 25px;
            border: 1px solid #ccc;
            border-radius: 5px; 
            background-color: #fcfcfc;
            font-size: 14px;
            box-sizing: border-box; 
            color: #555;
        }

        .btn-cancel {
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #eee;
        }

        .btn-save {
            background-color: #4285f4; 
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-save:hover {
            background-color: #3367d6;
        }

        .logo-top-right {
            text-align: right;
            margin-bottom: -40px; 
            position: relative;
            top: -20px;
        }

    </style>
</head>
<body>

    <table class="top-header">
        <tr>
            <td class="header-left">Barberstop</td>
            <td class="header-center">Gestión de Citas</td>
            <td class="header-right">👤</td>
        </tr>
    </table>

    <table class="main-container">
        <tr>
            <td align="center">
                
                <div style="width: 700px; background-color: white; padding: 40px; text-align: left;">
                    
                    <div class="logo-top-right">
                        <img src="logo.png" width="80" alt="Logo">
                    </div>

                    <h1>Programar Nueva Cita</h1>

                    <form action="guardar_cita.php" method="POST">
                        
                        <table width="100%" border="0">
                            <tr>
                                 <td>
                                    <label class="form-label">Nombre del cliente</label>
                                    <select name="id_cliente" class="form-select">
                                        <option value="">Seleccione un Cliente</option>
                                        <?php foreach($lista_clientes as $cliente): ?>
                                            <option value="<?php echo $cliente[0]; ?>">
                                                <?php echo $cliente[1]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="form-label">Barbero</label>
                                    <select name="id_barbero" class="form-select">
                                    <option value="">Seleccione un Barbero</option>
                                        <?php foreach($lista_barberos as $barbero): ?>
                                            <option value="<?php echo $barbero[0]; ?>">
                                                <?php echo $barbero[1]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="form-label">Fecha de la Cita</label>
                                    <input type="date" name="fecha" class="form-input">
                                </td>
                            </tr>

                           <tr>
                                <td>
                                    <label class="form-label">Hora de la Cita</label> 
                                    <select name="hora" class="form-select">
                                        <option value="">Seleccione hora</option>
                                    <?php 
                                        for($i=1; $i<=20; $i++) {
                                            $hora_formato = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";
                                            echo "<option value='$hora_formato'>$hora_formato</option>";
                                        }
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr><td height="30"></td></tr>

                            <tr>
                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td align="left">
                                                <a href="paginaP.php" class="btn-cancel">Cancelar</a>
                                            </td>
                                            <td align="right">
                                                <button type="submit" class="btn-save">Guardar Cita</button>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
                </td>
        </tr>
    </table>

</body>
</html>