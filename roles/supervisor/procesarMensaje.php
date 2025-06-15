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
$destinatarios = $_POST['destinatarios'] ?? [];
$mensaje = $_POST['mensaje'] ?? null;

if (empty($destinatarios)) {
    echo "<p style='color:red;'>Debes seleccionar al menos un destinatario.</p>";
    echo "<a href='mensajes.php'>Volver</a>";
    exit;
}

if (is_null($mensaje) || trim($mensaje) === '') {
    echo "<p style='color:red;'>El campo de mensaje no puede estar vacío.</p>";
    echo "<a href='mensajes.php'>Volver</a>";
    exit;
}

$fecha_envio = date("Y-m-d H:i:s");

// Insertar mensaje para cada destinatario
$insertar = $conexion->prepare("INSERT INTO mensajes (emisor_id, receptor_id, contenido, fecha_envio) VALUES (?, ?, ?, ?)");

foreach ($destinatarios as $id_usuario_destinatario) {
    // Obtener ID del empleado receptor a partir del ID del usuario
    $consulta_receptor = $conexion->prepare("SELECT id FROM empleados WHERE id_usuario = ?");
    $consulta_receptor->bind_param("i", $id_usuario_destinatario);
    $consulta_receptor->execute();
    $resultado_receptor = $consulta_receptor->get_result();

    if ($resultado_receptor->num_rows > 0) {
        $id_empleado_receptor = $resultado_receptor->fetch_assoc()['id'];
        $insertar->bind_param("iiss", $id_empleado_emisor, $id_empleado_receptor, $mensaje, $fecha_envio);
        $insertar->execute();
    }
}

echo "<p style='color: green;'>Mensaje enviado a los destinatarios seleccionados.</p>";
echo "<a href='mensajes.php'>Volver</a>";
?><!DOCTYPE html>
<html>
<head>
    <title>Procesar Mensaje</title>
    <link rel="stylesheet" href="../../css/supervisor/procesarMensaje.css">
</head>
<body>