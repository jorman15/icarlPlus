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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $clasificacion = $_POST['clasificacion'];

  
    $sql = "UPDATE repuestos SET marca = ?, tipo = ?, clasificacion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
       
        $stmt->bind_param('sssi', $marca, $tipo, $clasificacion, $id);
        $stmt->execute();

     
        if ($stmt->affected_rows > 0) {
            $_SESSION['mensaje'] = 'Los datos del repuesto han sido actualizados';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar los datos del repuesto';
        }

     
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = 'Error en la consulta SQL: ' . $conn->error;
    }

   
    header('Location: ../repuestos.php');
    exit();
}

?>