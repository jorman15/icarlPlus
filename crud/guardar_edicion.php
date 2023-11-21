<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $clienteId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];



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

    // Consulta para actualizar los datos del cliente
    $sql = "UPDATE clientes SET nombre = '$nombre', apellido = '$apellido', correo_electronico = '$email', telefono = '$telefono' WHERE id = $clienteId";

    if ($conn->query($sql) === TRUE) {
        
        $_SESSION['mensaje'] = "Los cambios se guardaron exitosamente";
        header("Location: ../clientes.php");
        exit();
    } else {
        
        $_SESSION['mensaje'] = "Error al guardar los cambios: " . $conn->error;
        header("Location: editar_cliente.php?id=$clienteId");
        exit();
    }

    // Cerrar la conexión
    $conn->close();
} else {

    header("Location: ../clientes.php");
    exit();
}
?>