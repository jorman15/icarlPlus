<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mecanicoId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "icarl";

   
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

   
    $sql = "UPDATE mecanicos SET nombre = '$nombre', apellido = '$apellido', correo_electronico = '$email', telefono = '$telefono' WHERE id = $mecanicoId";

    if ($conn->query($sql) === TRUE) {
        
        $_SESSION['mensaje'] = "Los cambios se guardaron exitosamente";
        header("Location: ../mecanicos.php");
        exit();
    } else {
        
        $_SESSION['mensaje'] = "Error al guardar los cambios: " . $conn->error;
        header("Location: editar_mecanico.php?id=$mecanicoId");
        exit();
    }

    
    $conn->close();
} else {
    
    header("Location: ../mecanicos.php");
    exit();
}
?>