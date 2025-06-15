<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Verificar que la sesión esté iniciada
if (!isset($_SESSION['usuario'])) {
    echo "Error: sesión no iniciada.";
    exit;
}

$id_usuario = $_SESSION['usuario']['id'];

// Obtener el id del empleado actual
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

$id_empleado_actual = $empleado['id'];

// Obtener todos los empleados excepto Gerente, RRHH, Tesorero y el mismo usuario
$sql = "SELECT e.id, u.nombre, u.rol, e.area 
        FROM empleados e
        JOIN usuarios u ON e.id_usuario = u.id
        WHERE u.rol NOT IN ('Gerente', 'Recursos Humanos', 'Tesorero')
        AND e.id != ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_empleado_actual);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enviar Mensaje</title>
    <link rel="stylesheet" href="../../css/supervisor/mensajes.css">
</head>

<body>
    <h1>Enviar Mensaje</h1>
    <form action="procesarMensaje.php" method="POST">
        <h3>Selecciona destinatarios:</h3>
        <div class="checkbox-group">
<?php while($row = $resultado->fetch_assoc()): ?>
    <label>
        <input type="checkbox" name="destinatarios[]" value="<?php echo $row['id']; ?>">
        <?php echo $row['nombre'] . " - " . $row['rol'] . " - " . $row['area']; ?>
    </label>
<?php endwhile; ?>
</div>
        
        <br>
        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" rows="5" cols="40" required></textarea><br><br>
        
        <input type="submit" value="Enviar Mensaje">
    </form>
</body>
</html>
