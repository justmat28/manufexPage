<?php
session_start();
include('../../baseDatos/database.php');
include('barraNavegacion.php');

if (!isset($_SESSION['usuario'])) {
    echo "Acceso denegado.";
    exit;
}

$usuario = $_SESSION['usuario'];
$id_usuario = $usuario['id'];

// Obtener el id del empleado a partir del id_usuario
$queryEmpleado = $conexion->prepare("SELECT id FROM empleados WHERE id_usuario = ?");
$queryEmpleado->bind_param("i", $id_usuario);
$queryEmpleado->execute();
$resultadoEmpleado = $queryEmpleado->get_result();

if ($resultadoEmpleado->num_rows === 0) {
    echo "Empleado no encontrado.";
    exit;
}

$id_empleado = $resultadoEmpleado->fetch_assoc()['id'];

// Obtener los mensajes de falta de personal recibidos
$query = "
    SELECT m.contenido, m.fecha_envio, u.nombre AS nombre_emisor
    FROM mensajes m
    JOIN empleados e_emisor ON m.emisor_id = e_emisor.id
    JOIN usuarios u ON e_emisor.id_usuario = u.id
    WHERE m.receptor_id = ?
    ORDER BY m.fecha_envio DESC
";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$resultado = $stmt->get_result();

echo "<h2>Notificaciones de falta de personal</h2>";

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px'>";
        echo "<strong>Supervisor:</strong> " . htmlspecialchars($fila['nombre_emisor']) . "<br>";
        echo "<strong>Mensaje:</strong> " . htmlspecialchars($fila['contenido']) . "<br>";
        echo "<strong>Fecha:</strong> " . htmlspecialchars($fila['fecha_envio']) . "<br>";
        echo "</div>";
    }
} else {
    echo "<p>No tienes notificaciones recientes de falta de personal.</p>";
}

$stmt->close();
?>
