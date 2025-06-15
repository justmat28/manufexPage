<?php
session_start();
include '../../baseDatos/database.php';

if (!isset($_SESSION['usuario']['id'])) {
    echo "<h3 style='color:red;'>Error: No se encontró el ID de usuario en la sesión.</h3>";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];
$contenido = $_POST['contenido'];

// Obtener el ID y área del empleado
$sqlEmpleado = "SELECT id, area FROM empleados WHERE id_usuario = ?";
$stmtEmpleado = $conexion->prepare($sqlEmpleado);
$stmtEmpleado->bind_param("i", $id_usuario);
$stmtEmpleado->execute();
$resultEmpleado = $stmtEmpleado->get_result();
$empleado = $resultEmpleado->fetch_assoc();

if (!$empleado) {
    echo "<h3 style='color:red;'>Error: No se encontró el empleado correspondiente al usuario.</h3>";
    exit;
}

$id_emisor = $empleado['id'];
$area = $empleado['area'];

// Obtener los superiores de la misma área
$sqlSuperiores = "SELECT e.id FROM empleados e
                  JOIN usuarios u ON e.id_usuario = u.id
                  WHERE e.area = ? AND u.rol IN ('Supervisor', 'Jefe de Produccion', 'Jefe de Planta')";
$stmtSuperiores = $conexion->prepare($sqlSuperiores);
$stmtSuperiores->bind_param("s", $area);
$stmtSuperiores->execute();
$resultSuperiores = $stmtSuperiores->get_result();

$sqlMensaje = "INSERT INTO mensajes (emisor_id, receptor_id, contenido) VALUES (?, ?, ?)";
$stmtMensaje = $conexion->prepare($sqlMensaje);

// Enviar el mensaje a cada superior
while($superior = $resultSuperiores->fetch_assoc()) {
    $receptor_id = $superior['id'];
    $stmtMensaje->bind_param("iis", $id_emisor, $receptor_id, $contenido);
    $stmtMensaje->execute();
}

echo "<script>alert('Reporte de fallo enviado correctamente'); window.location.href = 'enviarReporteFallo.php';</script>";
exit();
?>
