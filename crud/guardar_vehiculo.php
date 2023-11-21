<?php
session_start();


require_once '../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen'];

        
        $nombreArchivo = $imagen['name'];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

       
        $nombreUnico = uniqid('imagen_') . '.' . $extension;

       
        $rutaDestinoImagen = '../imagenes/' . $nombreUnico;

        
        if (move_uploaded_file($imagen['tmp_name'], $rutaDestinoImagen)) {
           
        } else {
           
        }
    } else {
     
        $nombreUnico = 'imagen_predeterminada.jpg';
    }

    
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $clasificacion = $_POST['clasificacion'];

   
    $codigoBarras = uniqid(); // Genera un código de barras único

    // Genera el código de barras en formato PNG
    $barcodeGenerator = new BarcodeGeneratorPNG();
    $barcodeImage = $barcodeGenerator->getBarcode($codigoBarras, $barcodeGenerator::TYPE_CODE_128);

    // Guardar el código de barras en la carpeta "codebar"
    $nombreArchivoCodigoBarra = 'codebar_' . $codigoBarras . '.png';
    $rutaDestinoCodigoBarra = '../codebar/' . $nombreArchivoCodigoBarra;
    file_put_contents($rutaDestinoCodigoBarra, $barcodeImage);



   
    $conexion = new mysqli('localhost', 'root', '', 'icarl');

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

 
    $sql = "INSERT INTO vehiculos (marca, modelo, anio, clasificacion, codigo_barras, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        
        $stmt->bind_param('ssssss', $marca, $modelo, $anio, $clasificacion, $nombreArchivoCodigoBarra, $nombreUnico);
        $stmt->execute();

    
        if ($stmt->affected_rows > 0) {
            $_SESSION['mensaje'] = 'Registro de vehículo exitoso';
        } else {
            $_SESSION['mensaje'] = 'Error al insertar el vehículo en la base de datos';
        }

       
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = 'Error en la consulta SQL: ' . $conexion->error;
    }

    
    $conexion->close();
} else {
    
    $_SESSION['mensaje'] = 'Error al acceder a la página de guardado de vehículo';
}


header('Location: ../form/formulario_registro_vehiculo.php');
exit();
?>