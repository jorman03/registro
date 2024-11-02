<?php
session_start();
require_once '../inc/conexion.php';
require_once '../inc/funciones.php';

$errores = [
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = limpiar_dato($_POST['email']);
    $password = $_POST['password'];

    // Consultamos si el email existe
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_role'] = $usuario['rol'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['user_imagen'] = $usuario['imagen']; // Imagen de usuario
        
        header("Location: dashboard.php");
        exit;
    } else {
        $errores['error'] = 'Email o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0;
            background: url('../uploads/autumn-4145_256.gif') no-repeat center center fixed; 
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .caja {
            display: grid;
            place-items: center;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 50px;
            background-color: white;
        }

        a {
            padding-right: 20px;
            text-decoration: none;
            color: black;
            font-size: 20px;
        }

        .formulario {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            position: relative;
            top: 55px;
            background-color: rgba(255, 255, 255, 0.5); /* Fondo semi-transparente */
            margin-bottom: 0px;
            height: 212px;
            padding-right: 5px;
            padding-left: 5px;
            border-radius: 20px; /* Bordes curvados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra suave */
            text-align: center;
            position: relative;
            border: 2px solid rgba(200, 0, 0, 0.5); /* Borde con un color similar */
            border-top-right-radius: 40px; /* Curvatura específica de la esquina superior derecha */
            border-top-left-radius: 10px; /* Curvatura específica de la esquina superior izquierda */
        }

        .formulario img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            position: absolute;
            top: -190px;
            left: 84px; /* Centrar imagen */
            border: 3px solid white;
            background-color: #fff;
        }

        h2 {
            margin-top: 0px;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
            font-size: 0.9em;
        }

        label {
            display: block;  /* Para que cada etiqueta esté en una línea separada */
            text-align: left; /* Alinea el texto a la izquierda */
            margin-bottom: 5px; /* Añade un pequeño margen inferior */
            font-size: 14px; /* Ajusta el tamaño de la fuente si lo deseas */
            color: #333; /* Ajusta el color del texto si lo prefieres */
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <header>
        <a href="../index.php">Index</a>
        <a href="registro.php">Registrar</a>
    </header>

    <div class="caja">
        <div class="formulario">
            <!-- Imagen del usuario -->
            <img src="../uploads/sea-of-clouds-13690_256.gif" alt="Usuario">

            <h2>Inicio de Sesión</h2>

            <?php if (!empty($errores['error'])): ?>
                <p class="error"><?php echo $errores['error']; ?></p>
            <?php endif; ?>
    
            <form method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>

</body>
</html>
