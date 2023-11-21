<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


if (isset($_POST['clientes']) && is_array($_POST['clientes'])) {
    $clientes = $_POST['clientes'];

    
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    
    foreach ($clientes as $clienteId) {
        $sql = "DELETE FROM clientes WHERE id = $clienteId";
        $result = $conn->query($sql);
    }

    
    $conn->close();

    
    $_SESSION['mensaje'] = "Clientes eliminados correctamente.";
} else {
   
    $_SESSION['mensaje'] = "No se han seleccionado clientes para eliminar.";
}


header("Location: ../clientes.php");
exit();
?>