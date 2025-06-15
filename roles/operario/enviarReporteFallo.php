<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Validar que exista el ID de usuario en sesión
if (!isset($_SESSION['usuario']['id'])) {
    echo "<h3 style='color:red;'>Error: No se encontró el ID de usuario en la sesión.</h3>";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

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

$id_empleado = $empleado['id'];
$area = $empleado['area'];
?>

<link rel="stylesheet" href="../../css/operario/enviarReporteFallo.css">

<div class="contenedor-reporte">
    <h2>Reportar Falla de Máquina</h2>
    <form action="enviarMensajeFallo.php" method="POST">
        <label for="contenido">Descripción del fallo:</label><br>
        <textarea name="contenido" id="contenido" rows="5" required></textarea><br><br>
        <input type="submit" value="Enviar Reporte">
    </form>
</div>
