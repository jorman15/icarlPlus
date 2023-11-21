<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


$cliente = $_POST['cliente'];
$tipoServicio = $_POST['tipo_servicio'];
$repuesto = isset($_POST['repuesto']) ? $_POST['repuesto'] : 'Repuesto no asignado';


$mecanico = isset($_POST['mecanico']) ? $_POST['mecanico'] : 'Mecánico no asignado';
$vehiculo = $_POST['vehiculo'];
$fecha = date('Y-m-d'); // Obtiene la fecha actual


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


$sqlInsertVenta = "INSERT INTO ventas (cliente, tipo_servicio, repuesto, mecanico, vehiculo, fecha) VALUES ('$cliente', '$tipoServicio', ";

if (!empty($repuesto)) {
    $sqlInsertVenta .= "'$repuesto'";
} else {
    $sqlInsertVenta .= "NULL";
}

$sqlInsertVenta .= ", ";

if (!empty($mecanico)) {
    $sqlInsertVenta .= "'$mecanico'";
} else {
    $sqlInsertVenta .= "NULL";
}

$sqlInsertVenta .= ", '$vehiculo', '$fecha')";

if ($conn->query($sqlInsertVenta) === TRUE) {
    $_SESSION['mensaje'] = "Registro de venta exitoso";
} else {
    $_SESSION['mensaje'] = "Error al registrar la venta: " . $conn->error;
}


$conn->close();

// Redirigir de vuelta a la página de registro de venta
header("Location: ../form/formulario_registro_venta.php");
exit();
?>