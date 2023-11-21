<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


$conn = new mysqli($servername, $username, $password, $dbname);

// Obtener el ID del repuesto a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos del repuesto a editar
    $sql = "SELECT * FROM repuestos WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Asignar el valor y ejecutar la consulta
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró el repuesto
        if ($result->num_rows === 1) {
            $repuesto = $result->fetch_assoc();
        } else {
            // No se encontró el repuesto, redirigir o mostrar un mensaje de error
            $_SESSION['mensaje'] = 'No se encontró el repuesto';
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
    $_SESSION['mensaje'] = 'No se proporcionó un ID de repuesto';
    header('Location: ../index.php');
    exit();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Repuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Editar Repuesto</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['mensaje'] == 'Los datos del repuesto han sido actualizados') ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form action="../crud/guardar_edicionr.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $repuesto['id']; ?>">

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $repuesto['marca']; ?>" required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control"
                id="tipo" name="tipo" value="<?php echo $repuesto['tipo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="clasificacion">Clasificación:</label>
                <input type="text" class="form-control" id="clasificacion" name="clasificacion" value="<?php echo $repuesto['clasificacion']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <section>
            <!-- Enlace para volver a la página principal de repuestos -->
            <a href="../repuestos.php" class="btn btn-secondary mt-3">Volver</a>
        </section>
    </div>
</body>

</html>