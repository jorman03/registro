<?php
session_start();
require_once '../inc/funciones.php';

if (!verificar_rol('admin')) {
    echo "Acceso denegado.";
    exit;
}

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'miproyecto'); // Ajusta con tus credenciales
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar los posts
$sql = "SELECT id, titulo, descripcion, imagen, updated_at, created_at FROM post WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Posts</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        .caja {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .post {
            width: 80%;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .post:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .post h3 {
            margin: 0 0 10px;
            color: #333;
        }
        .post p {
            color: #555;
            margin-bottom: 10px;
        }
        .post img {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .post hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin-top: 15px;
        }
        header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            background-color: #007bff;
            padding: 10px;
        }
        header a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            padding: 0 15px;
        }
        header a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <a href="dashboard.php">Volver al Dashboard</a>
        <a href="admin.php">Área de Administración</a>
    </header>

    <div class="caja">
        <h2>Tus Posts</h2>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($fila['titulo']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($fila['descripcion'])); ?></p>
                    <?php if ($fila['imagen']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($fila['imagen']); ?>" alt="Imagen del post">
                    <?php endif; ?>
                    <p><strong>Fecha de creación:</strong> <?php echo htmlspecialchars($fila['created_at']); ?></p>
                    <hr>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No has realizado ningún post aún.</p>
        <?php endif; ?>

        <?php $stmt->close(); $conn->close(); ?>
    </div>
</body>
</html>
