<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Validar que exista el ID de usuario en la sesión
if (!isset($_SESSION['usuario']['id'])) {
    echo "<h3 style='color:red;'>Error: No se encontró el ID de usuario en la sesión.</h3>";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

// Obtener el área del empleado
$sqlEmpleado = "SELECT area FROM empleados WHERE id_usuario = ?";
$stmtEmpleado = $conexion->prepare($sqlEmpleado);
$stmtEmpleado->bind_param("i", $id_usuario);
$stmtEmpleado->execute();
$resultEmpleado = $stmtEmpleado->get_result();
$empleado = $resultEmpleado->fetch_assoc();

if (!$empleado) {
    echo "<h3 style='color:red;'>Error: No se encontró el empleado correspondiente al usuario.</h3>";
    exit;
}

$area = $empleado['area'];

// Determinar la imagen del horario según el área
$imagenHorario = '';
if ($area == 'Planta 1') {
    $imagenHorario = '../../images/horarioPlanta.jpg';
} elseif ($area == 'Planta 2') {
    $imagenHorario = '../../images/horarioPlanta.jpg';
} else {
    $imagenHorario = '../../images/horarioPlanta.jpg';
}
?>

<link rel="stylesheet" href="../../css/obrero/verHorario.css">

<div class="contenedor-horario">
    <h2>Mi Horario de Trabajo</h2>
    <div class="imagen-horario">
        <img src="<?php echo $imagenHorario; ?>" alt="Horario de Trabajo">
    </div>
</div>
