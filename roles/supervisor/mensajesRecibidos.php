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

// Obtener los mensajes recibidos por este empleado
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

<link rel="stylesheet" href="../../css/supervisor/mensajesRecibidos.css">

<h2>Mensajes Recibidos</h2>

<div class="contenedor-mensajes">
<?php if ($resultMensajes->num_rows > 0): ?>
    <ul class="lista-mensajes">
        <?php while ($mensaje = $resultMensajes->fetch_assoc()): ?>
            <li>
                <strong>De:</strong> <?= htmlspecialchars($mensaje['remitente']) ?><br>
                <strong>Fecha:</strong> <?= htmlspecialchars($mensaje['fecha_envio']) ?><br>
                <strong>Contenido:</strong><br>
                <?= nl2br(htmlspecialchars($mensaje['contenido'])) ?>
                <hr>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p class="mensaje-vacio">No tienes mensajes recibidos.</p>
<?php endif; ?>
</div>
