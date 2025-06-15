<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

if (!isset($_SESSION['usuario']['id'])) {
    echo "<h3 style='color:red;'>Error: No se encontró el ID de usuario en la sesión.</h3>";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

// Obtener el ID del empleado asociado al usuario
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

// Procesar actualización del estado de una tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_estado'], $_POST['descripcion'])) {
    $nuevo_estado = $_POST['nuevo_estado'];
    $descripcion = $_POST['descripcion'];

    $sqlUpdate = "UPDATE tareas SET estado = ? WHERE descripcion = ? AND id_empleado = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $nuevo_estado, $descripcion, $id_empleado);
    $stmtUpdate->execute();

    $sqlProducto = "SELECT id_producto FROM tareas WHERE descripcion = ? AND id_empleado = ?";
    $stmtProd = $conexion->prepare($sqlProducto);
    $stmtProd->bind_param("si", $descripcion, $id_empleado);
    $stmtProd->execute();
    $resProd = $stmtProd->get_result();
    $rowProd = $resProd->fetch_assoc();

    if ($rowProd) {
        $id_producto = $rowProd['id_producto'];

        $sqlCheck = "SELECT COUNT(*) as incompletas FROM tareas WHERE id_producto = ? AND estado != 'Completada'";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $id_producto);
        $stmtCheck->execute();
        $resCheck = $stmtCheck->get_result();
        $incompletas = $resCheck->fetch_assoc()['incompletas'];

        if ($incompletas == 0) {
            $conexion->query("UPDATE productos SET estado = 'Completado' WHERE id = $id_producto");
        }
    }

    header("Location: tareasAsignadas.php");
    exit;
}

// Obtener las tareas asignadas con detalles
$sqlTareas = "SELECT t.descripcion, t.fecha_asignacion, t.fecha_limite, t.estado,
                     p.nombre_producto,
                     u.nombre AS asignador
              FROM tareas t
              LEFT JOIN productos p ON t.id_producto = p.id
              LEFT JOIN usuarios u ON t.id_usuario_asignador = u.id
              WHERE t.id_empleado = ?";
$stmtTareas = $conexion->prepare($sqlTareas);
$stmtTareas->bind_param("i", $id_empleado);
$stmtTareas->execute();
$resultTareas = $stmtTareas->get_result();
?>

<!-- Enlace al CSS -->
<link rel="stylesheet" href="../../css/operario/tareasAsignadas.css">

<div id="contenedor-tareas">
    <h2>Mis Tareas Asignadas</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Asignado por</th>
            <th>Descripción</th>
            <th>Fecha Asignación</th>
            <th>Fecha Límite</th>
            <th>Estado</th>
        </tr>
        <?php while($tarea = $resultTareas->fetch_assoc()): ?>
        <tr>
            <td><?= $tarea['nombre_producto'] ?? 'Ninguno'; ?></td>
            <td><?= $tarea['asignador'] ?? 'Desconocido'; ?></td>
            <td><?= $tarea['descripcion']; ?></td>
            <td><?= $tarea['fecha_asignacion']; ?></td>
            <td><?= $tarea['fecha_limite']; ?></td>
            <td><?= htmlspecialchars($tarea['estado']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
