<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
    include "mysqli_aux.php";

    $sql = "SELECT citas.*, clientes.nombre_cliente 
            FROM citas 
            INNER JOIN clientes ON citas.id_cliente = clientes.id_cliente";
    
    $datos_crudos = seleccionar($sql, "localhost", "barberias", "root", "n0m3l0");

    $citas_por_fecha = [];
    if ($datos_crudos) {
        foreach ($datos_crudos as $cita) {
            $fecha_cita = $cita[4]; 
            $citas_por_fecha[$fecha_cita][] = $cita;
        }
    }
    $month = date('m'); 
    $year = date('Y');
    $primer_dia_timestamp = mktime(0, 0, 0, $month, 1, $year);
    $numero_dias = date('t', $primer_dia_timestamp); 
    $dia_semana_inicio = date('w', $primer_dia_timestamp); 

    $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    $dias_semana = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Barberstop Interface</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            height: 100vh;
        }

        .layout-table {
            width: 100%;
            height: 100vh;
            border-collapse: collapse;
        }

        .header-row {
            height: 60px;
        }

        .header-brand {
            width: 20%;
            background-color: #555555;
            color: white;
            padding-left: 20px;
            font-size: 20px;
        }

        .header-nav {
            width: 80%;
            text-align: right;
            padding-right: 20px;
            border-bottom: 1px solid #ccc;
        }

        .body-row {
            vertical-align: top;
        }

        .sidebar {
            background-color: #f4f4f4;
            height: 100%;
            vertical-align: top;
            padding-top: 20px;
        }

        .menu-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 5px;
        }

        .menu-item {
            background-color: #666666;
            padding: 0; 
        }

        .menu-link {
            display: block;       
            width: 100%;
            height: 100%;
            padding: 15px;        
            color: white;         
            text-decoration: none; 
            font-weight: bold;
            box-sizing: border-box; 
        }

        .menu-link:hover {
            background-color: #555; 
        }

        .menu-item.active {
            background-color: #e0e0e0;
            border-left: 5px solid #ccc;
        }

        .menu-item.active .menu-link {
            color: black;
            cursor: default; 
        }
        
        .menu-item.active .menu-link:hover {
            background-color: transparent; 
        }

        .sidebar-logo-container {
            margin-top: 150px;
            text-align: center;
        }

        .main-content {
            padding: 40px;
            vertical-align: top;
        }

        .title-table {
            width: 40%;
            background-color: #cccccc;
            margin-bottom: 30px;
        }

        .title-table td {
            padding: 15px;
            text-align: center;
        }

        .title-table h2 {
            margin: 0;
            color: #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            margin-bottom: 40px;
        }

        .data-table th, 
        .data-table td {
            padding: 12px;
            border: 1px solid #000;
            text-align: left;
        }

        .data-table th {
            border-bottom: 2px solid black;
            font-weight: bold;
        }

        .icon-trash {
            color: red;
            cursor: pointer;
            margin-left: 5px;
            text-decoration: none;
        }

        .actions-table {
            width: 100%;
        }

        .actions-cell {
            text-align: right;
            padding-top: 20px;
        }

        .btn-logout {
            cursor: pointer;
            font-weight: bold;
            color: #555;
            margin-right: 20px;
            vertical-align: middle;
            font-size: 14px;
        }

        .btn-logout:hover {
            color: #000;
            text-decoration: underline;
        }

        .btn-add {
            background-color: #555;
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            vertical-align: middle;
        }
        .btn-update {
            background-color: #007bff; 
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-update:hover {
            background-color: #0056b3;
        }

        .btn-add:hover {
            background-color: #333;
        }
        .calendar-header-table { width: 100%; margin-bottom: 20px; }
        .calendar-title { font-size: 24px; color: #333; font-weight: bold; }
        .calendar-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .calendar-table th { background-color: #333; color: white; padding: 10px; text-align: center; }
        .calendar-table td { 
            height: 120px; 
            vertical-align: top; border: 1px solid #ccc; padding: 5px; background-color: white; 
        }
        .calendar-day-number { font-weight: bold; margin-bottom: 5px; display: block; text-align: right; color: #555; }
        .cita-item {
            background-color: #e3f2fd; border-left: 3px solid #2196F3;
            font-size: 11px; padding: 4px; margin-bottom: 3px; border-radius: 2px;
        }
    </style>
</head>
<body>
    <table class="layout-table">
        <tr class="header-row">
            <td class="header-brand"><span>👤 <strong>Barberstop</strong></span></td>
        </tr>
        <tr class="body-row">
            <td class="sidebar">
                <table class="menu-table">
                    <tr><td class="menu-item active"><a href="paginaP.php" class="menu-link">Agenda</a></td></tr>
                    <tr><td class="menu-item"><a href="servicios.php" class="menu-link">Servicios</a></td></tr>
                    <tr><td class="menu-item"><a href="barberos.php" class="menu-link">Barberos</a></td></tr>
                    <tr><td class="menu-item"><a href="clientes.php" class="menu-link">Clientes</a></td></tr>
                </table>
                <div class="sidebar-logo-container">
                    <img src="logo.png" alt="Logo Barberstop" width="150">
                </div>
            </td>
            <td class="main-content">
                <div class="title-container">
                    <table class="title-table">
                        <tr><td><h2>Citas Programadas</h2></td></tr>
                    </table>
                </div>
                <table class="calendar-header-table">
                    <tr>
                        <td class="calendar-title">
                            📅 <?php echo $meses[intval($month)] . " " . $year; ?>
                        </td>
                    </tr>
                </table>
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <?php foreach($dias_semana as $dia): ?>
                                <th><?php echo $dia; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            for ($i = 0; $i < $dia_semana_inicio; $i++) {
                                echo "<td style='background-color: #f9f9f9;'></td>";
                            }
                            for ($dia = 1; $dia <= $numero_dias; $dia++) {
                                $fecha_actual = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($dia, 2, "0", STR_PAD_LEFT);
                                echo "<td>";
                                    echo "<span class='calendar-day-number'>$dia</span>";
                                    if (isset($citas_por_fecha[$fecha_actual])) {
                                        foreach ($citas_por_fecha[$fecha_actual] as $cita) {
                                            $hora = substr($cita[3], 0, 5); 
                                            echo "<div class='cita-item'>";
                                            echo "<b>$hora</b> " . $cita[5];
                                            echo " <a href='borrar_cita.php?id=" . $cita[0] . "' style='text-decoration:none; color:red; float:right;'>🗑️</a>";
                                            echo "</div>";
                                        }
                                    }
                                echo "</td>";
                                if (($dia_semana_inicio + $dia) % 7 == 0 && $dia < $numero_dias) {
                                    echo "</tr><tr>";
                                }
                            }
                            $celdas_restantes = 7 - (($dia_semana_inicio + $numero_dias) % 7);
                            if ($celdas_restantes < 7) {
                                for ($i = 0; $i < $celdas_restantes; $i++) echo "<td style='background-color: #f9f9f9;'></td>";
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
                <table class="actions-table">
                    <tr>
                       <td class="actions-cell">
                        <a href="logginapp.php?accion=logout" class="btn-logout">🚪 Cerrar Sesión</a>

                        <a href="actualizar_cita.php" style="text-decoration: none;">
                            <button class="btn-update">Actualizar Cita</button>
                        </a>
                        <a href="agregar_cita.php" style="text-decoration: none;">
                            <button class="btn-add">Agregar Cita</button>
                        </a>
                    </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>