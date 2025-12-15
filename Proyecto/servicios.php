<?php
     session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: logginapp.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios - Barberstop</title>
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

        .main-content { padding: 30px; vertical-align: top; }
        
        .page-title-banner {
            background-color: #cccccc;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            width: 200px; 
            text-align: center;
        }
        .category-banner {
            background-color: #4285f4;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 40px;
            border-radius: 5px;
        }
        .services-grid-table {
            width: 100%;
            border-spacing: 30px; 
            border-collapse: separate;
        }
        .service-cell {
            text-align: center;
            vertical-align: top;
            width: 25%;
        }
        .image-placeholder {
            width: 100%;
            height: 180px; 
            border: 2px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            font-style: italic;
            color: #999;
            background-color: white;
            transition: all 0.3s ease; 
            cursor: pointer;
        }
        .image-placeholder:hover {
            border-color: #4285f4; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
            transform: translateY(-2px); 
        }
        .service-caption {
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        .image-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
        }
        .image-placeholder {
            border: 2px solid #ddd; 
            padding: 0; 
            overflow: hidden; 
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
                    <tr><td class="menu-item active"><a href="servicios.php" class="menu-link">Servicios</a></td></tr>
                    <tr><td class="menu-item"><a href="barberos.php" class="menu-link">Barberos</a></td></tr>
                    <tr><td class="menu-item"><a href="clientes.php" class="menu-link">Clientes</a></td></tr>
                </table>
                <div class="sidebar-logo-container">
                    <img src="logo.png" alt="Logo" width="120">
                </div>
            </td>

            <td class="main-content">
                
                <div class="page-title-banner">Servicios</div>

                <div class="category-banner">Cortes de Cabello</div>

                <table class="services-grid-table">
                    <tr>
                        <td class="service-cell">
                            <div class="image-placeholder">
                                <img src="corte_caballero.jpg" alt="Corte Caballero">
                            </div>
                            <p class="service-caption">Corte Caballero</p>
                        </td>
                        <td class="service-cell">
                           <div class="image-placeholder">
                                <img src="diseno_cejas.jpg" alt="Diseño cejas">
                            </div>
                            <p class="service-caption">Diseño cejas</p>
                        </td>
                        <td class="service-cell">
                            <div class="image-placeholder">
                                <img src="arreglo_barba.jpg" alt="Arreglo barba">
                            </div>
                            <p class="service-caption">Arreglo barba</p>
                        </td>
                        <td class="service-cell">
                            <div class="image-placeholder">
                                <img src="combo.jpg" alt="Corte y barba combo">
                            </div>
                            <p class="service-caption">Corte y barba combo</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="service-cell">
                            <div class="image-placeholder">
                                <img src="corte_infantil.jpg" alt="Corte infantil">
                            </div>
                            <p class="service-caption">Corte infantil</p>
                        </td>
                        <td class="service-cell">
                            <div class="image-placeholder">
                                <img src="tratamiento.jpg" alt="Tratamiento capilar">
                            </div>
                            <p class="service-caption">Tratamiento capilar</p>
                        </td>
                        <td class="service-cell"></td>
                        <td class="service-cell"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>