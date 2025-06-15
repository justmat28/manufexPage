<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

if (!isset($_SESSION['usuario'])) {
    echo "<p style='color:red;'>Error: No has iniciado sesión.</p>";
    exit;
}

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['usuario']['id'];

// Obtener el ID del empleado correspondiente
$sqlEmpleado = "SELECT id FROM empleados WHERE id_usuario = ?";
$stmtEmpleado = $conexion->prepare($sqlEmpleado);
$stmtEmpleado->bind_param("i", $usuario_id);
$stmtEmpleado->execute();
$resultadoEmpleado = $stmtEmpleado->get_result();

if ($resultadoEmpleado->num_rows === 0) {
    echo "<p style='color:red;'>No se encontró un empleado asociado.</p>";
    exit;
}

$empleado = $resultadoEmpleado->fetch_assoc();
$empleado_id = $empleado['id'];

?>

<link rel="stylesheet" href="../../css/operario/verMensajes.css">

<div class="contenedor-mensajes">
    <h2>Mensajes Recibidos</h2>

<?php
$sql = "SELECT m.id, u.nombre AS remitente, m.contenido, m.fecha_envio
        FROM mensajes m
        JOIN empleados e ON m.emisor_id = e.id
        JOIN usuarios u ON e.id_usuario = u.id
        WHERE m.receptor_id = ?
        ORDER BY m.fecha_envio DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $empleado_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>De</th><th>Mensaje</th><th>Fecha</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['remitente']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['contenido']) . "</td>";
        echo "<td>" . $fila['fecha_envio'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='sin-mensajes'>No tienes mensajes.</p>";
}
?>
</div>
