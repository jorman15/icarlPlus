<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


$conn = new mysqli($servername, $username, $password, $dbname);

// Obtener el ID del vehículo a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos del vehículo a editar
    $sql = "SELECT * FROM vehiculos WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Asignar el valor y ejecutar la consulta
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró el vehículo
        if ($result->num_rows === 1) {
            $vehiculo = $result->fetch_assoc();
        } else {
            // No se encontró el vehículo, redirigir o mostrar un mensaje de error
            $_SESSION['mensaje'] = 'No se encontró el vehículo';
            header('Location: ../index.php');
            exit();
        }

        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = 'Error en la consulta SQL: ' . $conn->error;
        header('Location: ../index.php');
        exit();
    }
} else {
    // Si no se proporciona un ID, redirigir o mostrar un mensaje de error
    $_SESSION['mensaje'] = 'No se proporcionó un ID de vehículo';
    header('Location: ../index.php');
    exit();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Editar Vehículo</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['mensaje'] == 'Los datos del vehículo han sido actualizados') ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form action="../crud/guardar_edicionv.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $vehiculo['id']; ?>">

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $vehiculo['marca']; ?>" required>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $vehiculo['modelo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="anio">Año:</label>
                <input type="number" class="form-control" id="anio" name="anio" value="<?php echo $vehiculo['anio']; ?>" required>
            </div>

            <div class="form-group">
                <label for="clasificacion">Clasificación:</label>
                <input type="text" class="form-control" id="clasificacion" name="clasificacion" value="<?php echo $vehiculo['clasificacion']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <section>
            <!-- Enlace para volver a la página principal de vehículos -->
            <a href="../vehiculos.php" class="btn btn-secondary mt-3">Volver</a>
        </section>
    </div>
</body>

</html>