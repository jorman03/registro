<?php
session_start();
require_once '../inc/funciones.php'; // Incluye funciones de conexión a la base de datos y otras utilidades

// Verificar si el usuario es admin (ajustar según los permisos de tu aplicación)
if (!verificar_rol('admin')) {
    echo "Acceso denegado.";
    exit;
}

$mensaje = ''; // Variable para almacenar mensajes de error o éxito

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación de campos
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $usuario_id = $_SESSION['user_id']; // ID del usuario que está logueado

    if (empty($titulo) || empty($descripcion) || !isset($_FILES['imagen'])) {
        $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
        header('Location: admin.php'); // Redirige de vuelta si hay error
        exit;
    }

    // Subir imagen
    $nombre_imagen = basename($_FILES['imagen']['name']);
    $ruta_destino = '../uploads/' . $nombre_imagen;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
        $_SESSION['mensaje'] = "Error al subir la imagen.";
        header('Location: admin.php');
        exit;
    }

    // Conexión e inserción en la base de datos
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=miproyecto', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO post (titulo, descripcion, imagen, usuario_id) VALUES (:titulo, :descripcion, :imagen, :usuario_id)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $nombre_imagen);
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Datos insertados correctamente.";
            // Redirigir a postprivado.php con el user_id como parámetro en la URL
            header("Location: postprivado.php?user_id=$usuario_id");
            exit;
        } else {
            $_SESSION['mensaje'] = "Error al insertar los datos.";
            header('Location: admin.php');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error de base de datos: " . $e->getMessage();
        header('Location: admin.php');
        exit;
    }
} else {
    $_SESSION['mensaje'] = "Método de solicitud no válido.";
    header('Location: admin.php');
    exit;
}
