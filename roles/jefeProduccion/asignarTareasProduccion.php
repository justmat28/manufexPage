<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

$sqlEmpleados = "SELECT e.id, u.nombre, u.rol, e.area 
                 FROM empleados e
                 JOIN usuarios u ON e.id_usuario = u.id
                 WHERE u.rol NOT IN ('Recursos Humanos', 'Tesorero')";
$resultadoEmpleados = $conexion->query($sqlEmpleados);

$empleadoSeleccionado = isset($_GET['id_empleado']) ? $_GET['id_empleado'] : null;
$areaEmpleado = null;

if ($empleadoSeleccionado) {
    $consultaArea = "SELECT area FROM empleados WHERE id = $empleadoSeleccionado";
    $resultadoArea = $conexion->query($consultaArea);
    if ($resultadoArea && $resultadoArea->num_rows > 0) {
        $areaEmpleado = $resultadoArea->fetch_assoc()['area'];

        $sqlProductos = "SELECT id, nombre_producto, area_produccion 
                         FROM productos 
                         WHERE area_produccion = '$areaEmpleado'
                         AND estado IN ('Pendiente', 'En Proceso')";
        $resultadoProductos = $conexion->query($sqlProductos);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Tareas</title>
    <link rel="stylesheet" href="../../css/jefeProduccion/asignarTareasProduccion.css">
</head>
<body>
    <main class="contenedor">
        <h2>Asignar Tareas a Empleados</h2>

        <form method="GET" action="asignarTareasProduccion.php" class="formulario-empleado">
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
            <form action="guardarTarea.php" method="POST" class="formulario-tarea">
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
                </select>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" placeholder="Describe la tarea..." required></textarea>

                <label for="fecha_limite">Fecha Límite:</label>
                <input type="date" name="fecha_limite" required>

                <input type="submit" value="Asignar Tarea" class="btn-guardar">
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
