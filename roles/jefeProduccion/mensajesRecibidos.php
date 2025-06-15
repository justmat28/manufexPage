<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

if (!isset($_SESSION['usuario']['id'])) {
    echo "<h3 style='color:red;'>Error: No se encontró el ID de usuario en la sesión.</h3>";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

// Obtener ID del empleado
$sqlEmpleado = "SELECT id FROM empleados WHERE id_usuario = ?";
$stmtEmpleado = $conexion->prepare($sqlEmpleado);
$stmtEmpleado->bind_param("i", $id_usuario);
$stmtEmpleado->execute();
$resultEmpleado = $stmtEmpleado->get_result();
$empleado = $resultEmpleado->fetch_assoc();

if (!$empleado) {
    echo "<h3 style='color:red;'>Error: No se encontró el empleado correspondiente al usuario.</h3>";
    exit;
}

$id_empleado = $empleado['id'];

// Obtener los mensajes recibidos
$sqlMensajes = "SELECT m.id, m.contenido, m.fecha_envio, u.nombre AS remitente
                FROM mensajes m
                JOIN empleados e ON m.emisor_id = e.id
                JOIN usuarios u ON e.id_usuario = u.id
                WHERE m.receptor_id = ?
                ORDER BY m.fecha_envio DESC";

$stmtMensajes = $conexion->prepare($sqlMensajes);
$stmtMensajes->bind_param("i", $id_empleado);
$stmtMensajes->execute();
$resultMensajes = $stmtMensajes->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes Recibidos - Jefe de Producción</title>
    <link rel="stylesheet" href="../../css/JefeProduccion/mensajesRecibidosJefeProduccion.css">
</head>
<body>
    <div class="contenedor-principal">
        <h2>📩 Mensajes Recibidos</h2>

        <?php if ($resultMensajes->num_rows > 0): ?>
            <?php while ($mensaje = $resultMensajes->fetch_assoc()): ?>
                <div class="mensaje">
                    <div class="cabecera">
                        <span><strong>De:</strong> <?= htmlspecialchars($mensaje['remitente']) ?></span>
                        <span><strong>Fecha:</strong> <?= htmlspecialchars($mensaje['fecha_envio']) ?></span>
                    </div>
                    <div class="contenido">
                        <?= nl2br(htmlspecialchars($mensaje['contenido'])) ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="sin-mensajes">No tienes mensajes recibidos.</p>
        <?php endif; ?>
    </div>
</body>
</html>
