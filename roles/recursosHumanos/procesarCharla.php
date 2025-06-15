<?php
session_start();
include '../../baseDatos/database.php';

$tipo = $_POST['tipo'];
$mensaje = $_POST['mensaje'];

// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    die("No has iniciado sesión.");
}

$id_usuario = $_SESSION['usuario']['id'];

// Buscar el id_empleado correspondiente a este usuario
$query_empleado = "SELECT id FROM empleados WHERE id_usuario = $id_usuario LIMIT 1";
$result_empleado = mysqli_query($conexion, $query_empleado);

if ($row_empleado = mysqli_fetch_assoc($result_empleado)) {
    $emisor_id = $row_empleado['id'];
} else {
    die("No se encontró el empleado asociado al usuario.");
}

// Buscar empleados que no son Gerente
$query = "
    SELECT e.id FROM empleados e
    JOIN usuarios u ON e.id_usuario = u.id
    WHERE u.rol != 'Gerente'
";
$result = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $receptor_id = $row['id'];
    $contenido = "[{$tipo}] $mensaje";

    $contenido_escapado = mysqli_real_escape_string($conexion, $contenido);
    mysqli_query($conexion, "INSERT INTO mensajes (emisor_id, receptor_id, contenido) VALUES ($emisor_id, $receptor_id, '$contenido_escapado')");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Envío</title>
    <link rel="stylesheet" href="../../css/recursosHumanos/verCharlasConfirmacion.css">
</head>
<body>
    <div class="confirmacion-envio">
        <h2>Mensaje enviado</h2>
        <p>El mensaje ha sido enviado correctamente a todos los empleados (excepto Gerente).</p>
        <a class="boton-volver" href="enviarCharla.php">← Volver</a>
    </div>
</body>
</html>
