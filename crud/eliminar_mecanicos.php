<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


if (isset($_POST['mecanicos']) && is_array($_POST['mecanicos'])) {
    $mecanicos = $_POST['mecanicos'];

   
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    
    foreach ($mecanicos as $mecanicoId) {
        $sql = "DELETE FROM mecanicos WHERE id = $mecanicoId";
        $result = $conn->query($sql);
    }

    
    $conn->close();

    
    $_SESSION['mensaje'] = "Mecánicos eliminados correctamente.";
} else {
    
    $_SESSION['mensaje'] = "No se han seleccionado mecánicos para eliminar.";
}


header("Location: ../mecanicos.php");
exit();
?>