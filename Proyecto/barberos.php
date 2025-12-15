<?php
     session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
    include "mysqli_aux.php";
    $sql = "SELECT id_barbero, nombre_barbero FROM barberos ORDER BY id_barbero ASC";
    $lista_barberos = seleccionar($sql, "localhost", "barberias", "root", "n0m3l0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Equipo de Barberos - Barberstop</title>
    <style>
        body { margin: 0; padding: 0; font-family: sans-serif; height: 100vh; background-color: #fcfcfc; }
        .layout-table { width: 100%; height: 100vh; border-collapse: collapse; }
        .header-row { height: 60px; }
        .header-brand { width: 250px; background-color: #555555; color: white; padding-left: 20px; font-size: 20px; }
        .header-nav { background-color: white; text-align: right; padding-right: 20px; border-bottom: 2px solid #eee; }
        .body-row { vertical-align: top; }
        .sidebar { background-color: #f4f4f4; height: 100%; vertical-align: top; padding-top: 20px; width: 250px; border-right: 2px solid #eee; }
        .menu-table { width: 100%; border-collapse: separate; border-spacing: 0 5px; }
        .menu-item { background-color: #666666; padding: 0; }
        .menu-link { display: block; width: 100%; height: 100%; padding: 15px; color: white; text-decoration: none; font-weight: bold; box-sizing: border-box; }
        .menu-link:hover { background-color: #555; }
        .menu-item.active { background-color: #e0e0e0; border-left: 5px solid #ccc; }
        .menu-item.active .menu-link { color: black; cursor: default; }
        .menu-item.active .menu-link:hover { background-color: transparent; }
        .sidebar-logo-container { margin-top: 150px; text-align: center; }
        .main-content { padding: 40px; vertical-align: top; }

        .page-title-banner {
            background-color: #cccccc;
            padding: 10px 30px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 40px;
            display: inline-block; 
            border-radius: 2px;
        }
        .barberos-table {
            width: 80%; 
            border-collapse: collapse;
            border: 2px solid #000; 
        }
        .barberos-table th {
            text-align: left;
            padding: 15px;
            font-weight: normal; 
            font-size: 16px;
            color: #333;
            border-bottom: 1px solid #000; 
        }
        .barberos-table td {
            padding: 15px;
            border-bottom: 1px solid #000; 
            color: #000;
        }
        .barberos-table tr:last-child td {
            border-bottom: none;
        }

    </style>
</head>
<body>

    <table class="layout-table">
        <tr class="header-row">
            <td class="header-brand"><span>👤 <strong>Barberstop</strong></span></td>
            <td class="header-nav">
                <span style="font-size: 24px;">👤</span>
            </td>
        </tr>

        <tr class="body-row">
            <td class="sidebar">
                <table class="menu-table">
                    <tr><td class="menu-item"><a href="paginaP.php" class="menu-link">Agenda</a></td></tr>
                    <tr><td class="menu-item"><a href="servicios.php" class="menu-link">Servicios</a></td></tr>
                    <tr><td class="menu-item active"><a href="barberos.php" class="menu-link">Barberos</a></td></tr>
                    <tr><td class="menu-item"><a href="clientes.php" class="menu-link">Clientes</a></td></tr>
                </table>
                
                <div class="sidebar-logo-container">
                    <img src="logo.png" alt="Logo" width="120">
                </div>
            </td>

            <td class="main-content">
                
                <div class="page-title-banner">Barberos</div>

                <table class="barberos-table">
                    <thead>
                        <tr>
                            <th width="20%">id barbero</th>
                            <th width="80%">barbero</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lista_barberos as $barbero): ?>
                        <tr>
                            <td><?php echo $barbero[0]; ?></td>
                            
                            <td><?php echo $barbero[1]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                </table>
                <table class="actions-table">
                    <tr>
                       <td class="actions-cell">
                        <a href="logginapp.php?accion=logout" class="btn-logout">🚪 Cerrar Sesión</a>
                    </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>