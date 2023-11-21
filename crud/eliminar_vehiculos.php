<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


if (isset($_POST['vehiculos']) && is_array($_POST['vehiculos'])) {
    $vehiculos = $_POST['vehiculos'];

 
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

   
    foreach ($vehiculos as $vehiculoId) {
        $sql = "DELETE FROM vehiculos WHERE id = $vehiculoId";
        $result = $conn->query($sql);
    }

   
    $conn->close();

    
    $_SESSION['mensaje'] = "Vehículos eliminados correctamente.";
} else {
    
    $_SESSION['mensaje'] = "No se han seleccionado vehículos para eliminar.";
}


header("Location: ../vehiculos.php");
exit();
?>