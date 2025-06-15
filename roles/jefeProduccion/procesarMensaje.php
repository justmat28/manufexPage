<?php 
session_start();
include '../../baseDatos/database.php';

if (!isset($_SESSION['usuario'])) {
    echo "Error: sesión no iniciada.";
    exit;
}

$usuario = $_SESSION['usuario'];
$id_usuario_emisor = $usuario['id'];

// Obtener ID del empleado emisor
$consulta_emisor = $conexion->prepare("SELECT id FROM empleados WHERE id_usuario = ?");
$consulta_emisor->bind_param("i", $id_usuario_emisor);
$consulta_emisor->execute();
$resultado_emisor = $consulta_emisor->get_result();

if ($resultado_emisor->num_rows === 0) {
    echo "No se encontró el empleado emisor.";
    exit;
}

$id_empleado_emisor = $resultado_emisor->fetch_assoc()['id'];

// Validar que se haya enviado el formulario correctamente
$receptor_id = $_POST['receptor_id'] ?? null;
$mensaje = $_POST['contenido'] ?? null;

$resultado = '';
$claseResultado = '';

if (is_null($receptor_id) || !is_numeric($receptor_id)) {
    $resultado = 'Debes seleccionar un destinatario válido.';
    $claseResultado = 'error';
} elseif (is_null($mensaje) || trim($mensaje) === '') {
    $resultado = 'El campo de mensaje no puede estar vacío.';
    $claseResultado = 'error';
} else {
    $fecha_envio = date("Y-m-d H:i:s");
    $insertar = $conexion->prepare("INSERT INTO mensajes (emisor_id, receptor_id, contenido, fecha_envio) VALUES (?, ?, ?, ?)");
    $insertar->bind_param("iiss", $id_empleado_emisor, $receptor_id, $mensaje, $fecha_envio);
    $insertar->execute();
    $resultado = 'Mensaje enviado correctamente.';
    $claseResultado = 'exito';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Mensaje</title>
    <link rel="stylesheet" href="../../css/JefeProduccion/procesarMensajeJefeProduccion.css">
</head>
<body>
    <div class="contenedor">
        <div class="tarjeta">
            <h2>Resultado del envío</h2>
            <p class="<?php echo $claseResultado; ?>"><?php echo $resultado; ?></p>
            <a href="mensajes.php" class="boton">Volver</a>
        </div>
    </div>
</body>
</html>
