<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


if (isset($_POST['repuestos']) && is_array($_POST['repuestos'])) {
    $repuestos = $_POST['repuestos'];

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

   
    foreach ($repuestos as $repuestoId) {
        $sql = "DELETE FROM repuestos WHERE id = $repuestoId";
        $result = $conn->query($sql);
    }

   
    $conn->close();

    
    $_SESSION['mensaje'] = "Repuestos eliminados correctamente.";
} else {
   
    $_SESSION['mensaje'] = "No se han seleccionado repuestos para eliminar.";
}


header("Location: ../repuestos.php");
exit();
?>