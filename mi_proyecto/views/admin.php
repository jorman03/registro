<?php
session_start();
require_once '../inc/funciones.php';

if (!verificar_rol('admin')) {
    echo "Acceso denegado.";
    exit;
}

// Verificar si hay un mensaje de error o éxito en la sesión y almacenarlo en una variable
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']); // Limpiar el mensaje para la próxima solicitud
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0;
        }
        .caja {
            display: grid;
            place-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }
        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 50px;
        }
        a {
            padding-right: 20px;
            text-decoration: none;
            color: black;
            font-size: 27px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            gap: 10px;
        }
        input, textarea, button {
            padding: 8px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .mensaje {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .mensaje.exito {
            background-color: #d4edda;
            color: #155724;
        }
        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
    function validarFormulario() {
        // Limpiar errores previos
        document.getElementById('error-titulo').innerText = '';
        document.getElementById('error-descripcion').innerText = '';
        document.getElementById('error-imagen').innerText = '';

        let valido = true;

        const titulo = document.getElementById('titulo').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const imagen = document.getElementById('imagen').files.length;

        if (titulo === '') {
            document.getElementById('error-titulo').innerText = 'El título es obligatorio.';
            valido = false;
        }
        if (descripcion === '') {
            document.getElementById('error-descripcion').innerText = 'La descripción es obligatoria.';
            valido = false;
        }
        if (imagen === 0) {
            document.getElementById('error-imagen').innerText = 'Debes seleccionar una imagen.';
            valido = false;
        }

        return valido; // Si todo está correcto, enviará el formulario
    }
    </script>
</head>
<body>
    <header>
        <a href="dashboard.php">Volver al Dashboard</a>
        <a href="postprivado.php">Post privado</a>
    </header>

    <div class="caja">
        <div>
            <h2>Área de Administración</h2>
            <p>Solo para administradores.</p>
            <p>Id: <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>

            <!-- Mostrar mensaje de error o éxito -->
            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'exito'; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de inserción -->
            <form id="miFormulario" action="insertar.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo">
                <div id="error-titulo" class="error"></div>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"></textarea>
                <div id="error-descripcion" class="error"></div>

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
                <div id="error-imagen" class="error"></div>

                <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>
