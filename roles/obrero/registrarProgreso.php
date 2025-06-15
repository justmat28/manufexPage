<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Validar que exista un ID de usuario
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

// Obtener tareas asignadas
$sqlTareas = "SELECT * FROM tareas WHERE id_empleado = ?";
$stmtTareas = $conexion->prepare($sqlTareas);
$stmtTareas->bind_param("i", $id_empleado);
$stmtTareas->execute();
$resultTareas = $stmtTareas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Progreso</title>
    <link rel="stylesheet" href="../../css/obrero/registrarProgreso.css">
</head>
<body>
    <h2>Registrar Progreso de Tareas</h2>

    <div id="contenedor-progreso">
        <form action="guardarProgreso.php" method="POST">
            <label for="tarea">Selecciona una tarea:</label>
            <select name="id_tarea" id="tarea" required>
                <?php while($tarea = $resultTareas->fetch_assoc()): ?>
                    <option value="<?php echo $tarea['id']; ?>"><?php echo $tarea['descripcion']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="En progreso">En progreso</option>
                <option value="Completada">Completada</option>
            </select>

            <input type="submit" value="Actualizar Estado">
        </form>
    </div>
</body>
</html>
