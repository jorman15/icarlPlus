<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$correo = $_POST['email'];


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}


$sql = "INSERT INTO mecanicos (nombre, apellido, telefono, correo_electronico) VALUES ('$nombre', '$apellido', '$telefono', '$correo')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['mensaje'] = "Registro de mecánico exitoso";
} else {
    $_SESSION['mensaje'] = "Error al registrar el mecánico: " . $conn->error;
}


$conn->close();


header("Location: ../form/formulario_registro_mecanico.php");
exit;
?>