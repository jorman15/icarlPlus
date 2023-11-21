<?php
session_start();

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

// Consulta para obtener los clientes registrados
$sqlClientes = "SELECT nombre FROM clientes";
$resultClientes = $conn->query($sqlClientes);

// Array para almacenar los nombres de los clientes
$clientes = [];

// Verificar si se encontraron clientes
if ($resultClientes->num_rows > 0) {
    // Recorrer cada fila de resultados y agregar el nombre del cliente al array
    while ($row = $resultClientes->fetch_assoc()) {
        $clientes[] = $row['nombre'];
    }
}

// Consulta para obtener los repuestos registrados
$sqlRepuestos = "SELECT tipo FROM repuestos";
$resultRepuestos = $conn->query($sqlRepuestos);

// Array para almacenar los nombres de los repuestos
$repuestos = [];

// Verificar si se encontraron repuestos
if ($resultRepuestos->num_rows > 0) {
    // Recorrer cada fila de resultados y agregar el nombre del repuesto al array
    while ($row = $resultRepuestos->fetch_assoc()) {
        $repuestos[] = $row['tipo'];
    }
}

// Consulta para obtener los mecánicos registrados
$sqlMecanicos = "SELECT nombre FROM mecanicos";
$resultMecanicos = $conn->query($sqlMecanicos);

// Array para almacenar los nombres de los mecánicos
$mecanicos = [];

// Verificar si se encontraron mecánicos
if ($resultMecanicos->num_rows > 0) {
    // Recorrer cada fila de resultados y agregar el nombre del mecánico al array
    while ($row = $resultMecanicos->fetch_assoc()) {
        $mecanicos[] = $row['nombre'];
    }
}
// Consulta para obtener los vehículos registrados
$sqlVehiculos = "SELECT modelo FROM vehiculos";
$resultVehiculos = $conn->query($sqlVehiculos);

// Array para almacenar los nombres de los vehículos
$vehiculos = [];

// Verificar si se encontraron vehículos
if ($resultVehiculos->num_rows > 0) {
    // Recorrer cada fila de resultados y agregar el nombre del vehículo al array
    while ($row = $resultVehiculos->fetch_assoc()) {
        $vehiculos[] = $row['modelo'];
    }
}
// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registro de Venta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Registro de Venta</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['mensaje'] == 'Registro de venta exitoso') ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form action="../crud/guardar_venta.php" method="POST">
            <div class="form-group">
                <label for="cliente">Cliente:</label>
                <select name="cliente" id="cliente" class="form-control" required>
                    <option value="">Seleccionar cliente</option>
                    
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?php echo $cliente; ?>"><?php echo $cliente; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_servicio">Tipo de Servicio:</label>
                <select name="tipo_servicio" id="tipo_servicio" class="form-control" required>
                    <option value="">Seleccionar tipo de servicio</option>
                    <option value="venta">Venta</option>
                    <option value="reparacion">Reparación</option>
                </select>
            </div>

            <div class="form-group">
                <label for="repuesto">Repuesto:</label>
                <select name="repuesto" id="repuesto" class="form-control" disabled>
                    <option value="">Sin repuesto asignado</option>
                   
                    <?php foreach ($repuestos as $repuesto): ?>
                        <option value="<?php echo $repuesto; ?>"><?php echo $repuesto; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="mecanico">Mecánico:</label>
                <select name="mecanico" id="mecanico" class="form-control" disabled>
                    <option value="">Sin mecánico asignado</option>
                    
                    <?php foreach ($mecanicos as $mecanico): ?>
                        <option value="<?php echo $mecanico; ?>"><?php echo $mecanico; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="vehiculo">Vehículo:</label>
                <select name="vehiculo" id="vehiculo" class="form-control" required>
                    <option value="">Seleccionar vehículo</option>
                   
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value="<?php echo $vehiculo; ?>"><?php echo $vehiculo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <a href="../ventas.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <script>
        // Lógica para habilitar/deshabilitar los campos de repuesto y mecánico dependiendo del tipo de servicio seleccionado
        const tipoServicioSelect = document.getElementById('tipo_servicio');
        const repuestoSelect = document.getElementById('repuesto');
        const mecanicoSelect = document.getElementById('mecanico');

        tipoServicioSelect.addEventListener('change', function () {
            if (tipoServicioSelect.value === 'venta') {
                repuestoSelect.disabled = true;
                mecanicoSelect.disabled = true;
            } else if (tipoServicioSelect.value === 'reparacion') {
                repuestoSelect.disabled = false;
                mecanicoSelect.disabled = false;
            }
        });
    </script>
</body>

</html>