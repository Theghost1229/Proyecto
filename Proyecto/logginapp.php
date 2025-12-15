<?php 
    ini_set('display_errors', E_ALL);
    
    include "mysqli_aux.php"; 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $server = 'localhost';
    $base   = 'barberias';     
    $usr    = 'root';          
    $pass   = 'n0m3l0';              

    function destruirSesionYCookie() {
        session_unset();
        session_destroy();
        if (isset($_COOKIE['usuario_guardado'])) {
            setcookie("usuario_guardado", "", time() - 3600, "/");
        }
    }

    if (isset($_GET['accion']) && $_GET['accion'] === 'logout') {
        destruirSesionYCookie();
        header('Location: logginapp.php');
        exit();
    }

    if (isset($_SESSION['usuario'])) {
        header('Location: paginaP.php');
        exit();
    }

    $usuario_predefinido = "";
    if (isset($_COOKIE['usuario_guardado'])) {
        $usuario_predefinido = $_COOKIE['usuario_guardado'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        
        $sql = "SELECT * FROM credenciales WHERE usuario = '$usuario'";
        
        $resultados = seleccionar($sql, $server, $base, $usr, $pass);

        if ($resultados && count($resultados) > 0) {
            $contrasena_db = $resultados[0][2]; 
            if ($contrasena == $contrasena_db) {
                
                $_SESSION['usuario'] = $resultados[0][1];

                if (isset($_POST['recordarme'])) {
                    setcookie("usuario_guardado", $usuario, time() + (86400 * 30), "/");
                } else {
                    if (isset($_COOKIE['usuario_guardado'])) {
                        setcookie("usuario_guardado", "", time() - 3600, "/");
                    }
                }

                header('Location: paginaP.php');
                exit;

            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Iniciar sesión</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #fff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }

            h2 {
                background-color: #555555;
                color: white;
                padding: 15px 60px;
                text-align: center;
                font-weight: 500;
                font-size: 24px;
                margin-bottom: 40px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            form {
                width: 100%;
                max-width: 400px;
                padding: 0 20px;
                box-sizing: border-box;
            }

            label {
                font-weight: bold;
                color: #666;
                font-size: 14px;
                display: block;
                margin-bottom: 8px;
            }

            input[type="text"], 
            input[type="password"] {
                width: 100%;
                padding: 12px 15px;
                margin-bottom: 5px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 14px;
                color: #333;
                box-sizing: border-box;
            }

            p {
                margin-bottom: 20px;
            }

            .remember-me {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 20px;
            }
            .remember-me input {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }
            .remember-me label {
                margin-bottom: 0;
                color: #444;
                font-weight: normal;
                cursor: pointer;
            }

            input[type="submit"] {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 15px;
                width: 100%;
                border-radius: 8px;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            input[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <h2>Barberstop</h2>
        
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="logginapp.php" method="POST">
            <p>
                <label for="usuario">Nombre de Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingresa tu nombre de usuario" required>
            </p>
            <p>
                <label for="password">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa tu contraseña" required>
            </p>

            <div class="remember-me">
                <input type="checkbox" name="recordarme" id="recordarme">
                <label for="recordarme">Recordarme</label>
            </div>

            <p>
                <input type="submit" value="Iniciar Sesión">
            </p>
        </form>
    </body>
</html>