<?php
session_start();

// Verificar si se proporcionó el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    $clienteId = $_GET['id'];

  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "icarl";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Consulta para obtener los datos del cliente con el ID proporcionado
    $sql = "SELECT nombre, apellido, correo_electronico, telefono FROM clientes WHERE id = $clienteId";
    $result = $conn->query($sql);

    // Verificar si se encontró el cliente
    if ($result->num_rows > 0) {
        // Obtener los datos del cliente
        $cliente = $result->fetch_assoc();
    } else {
        // No se encontró el cliente, puedes mostrar un mensaje de error o redirigir a otra página
        $_SESSION['mensaje'] = "Cliente no encontrado";
        header("Location: ../clientes.php");
        exit();
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // No se proporcionó el parámetro 'id', redirigir a otra página
    $_SESSION['mensaje'] = "ID de cliente no especificado";
    header("Location: ../clientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form action="../crud/guardar_edicion.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $clienteId; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre" value="<?php echo $cliente['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa el apellido" value="<?php echo $cliente['apellido']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa el correo electrónico" value="<?php echo $cliente['correo_electronico']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingresa el teléfono" value="<?php echo $cliente['telefono']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <!-- Enlace para volver a la página principal de clientes -->
        <a href="../clientes.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>