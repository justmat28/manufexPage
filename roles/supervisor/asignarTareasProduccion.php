<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Obtener empleados válidos
$sqlEmpleados = "SELECT e.id, u.nombre, u.rol, e.area 
                 FROM empleados e
                 JOIN usuarios u ON e.id_usuario = u.id
                 WHERE u.rol NOT IN ('Recursos Humanos', 'Tesorero')";
$resultadoEmpleados = $conexion->query($sqlEmpleados);

// Obtener ID del empleado seleccionado (si lo hay)
$empleadoSeleccionado = isset($_GET['id_empleado']) ? $_GET['id_empleado'] : null;
$areaEmpleado = null;

if ($empleadoSeleccionado) {
    $consultaArea = "SELECT area FROM empleados WHERE id = $empleadoSeleccionado";
    $resultadoArea = $conexion->query($consultaArea);
    if ($resultadoArea && $resultadoArea->num_rows > 0) {
        $areaEmpleado = $resultadoArea->fetch_assoc()['area'];

        // Obtener productos relacionados con esa área y estado 'Pendiente' o 'En Proceso'
        $sqlProductos = "SELECT id, nombre_producto, area_produccion 
                         FROM productos 
                         WHERE area_produccion = '$areaEmpleado'
                         AND estado IN ('Pendiente', 'En Proceso')";
        $resultadoProductos = $conexion->query($sqlProductos);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asignar Tareas</title>
    <link rel="stylesheet" href="../../css/supervisor/asignarTareasProduccion.css">
</head>
<body>
    <h1>Asignar Tareas</h1>

    <!-- Selección del empleado -->
    <form method="GET" action="asignarTareasProduccion.php">
        <label for="empleado">Selecciona un empleado:</label>
        <select name="id_empleado" onchange="this.form.submit()" required>
            <option value="">-- Selecciona --</option>
            <?php
            $resultadoEmpleados->data_seek(0);
            while($row = $resultadoEmpleados->fetch_assoc()):
            ?>
                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $empleadoSeleccionado) echo "selected"; ?>>
                    <?php echo $row['nombre'] . " - " . $row['rol'] . " - " . $row['area']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($empleadoSeleccionado && $areaEmpleado): ?>
        <form action="guardarTarea.php" method="POST">
            <input type="hidden" name="id_empleado" value="<?php echo $empleadoSeleccionado; ?>">

            <label for="producto">Producto relacionado:</label>
            <select name="id_producto">
                <option value="">Ninguno</option>
                <?php if ($resultadoProductos): ?>
                    <?php while($prod = $resultadoProductos->fetch_assoc()): ?>
                        <option value="<?php echo $prod['id']; ?>">
                            <?php echo $prod['nombre_producto'] . " - " . $prod['area_produccion']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select><br><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea name="descripcion" required></textarea><br><br>

            <label for="fecha_limite">Fecha Límite:</label><br>
            <input type="date" name="fecha_limite" required><br><br>

            <input type="submit" value="Asignar Tarea">
        </form>
    <?php endif; ?>
</body>
</html>
