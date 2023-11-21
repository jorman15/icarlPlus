<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icarl";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


if (isset($_POST['ventas'])) {
    $ventas = $_POST['ventas'];

   
    $ventasIds = implode(",", $ventas);

    
    $sql = "DELETE FROM ventas WHERE id IN ($ventasIds)";

   
    if ($conn->query($sql) === TRUE) {
        
        $_SESSION['mensaje'] = "Ventas anuladas correctamente";
    } else {
       
        $_SESSION['mensaje'] = "Error al eliminar las ventas: " . $conn->error;
    }
}


header("Location: ../ventas.php");
exit();


$conn->close();