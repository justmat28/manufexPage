<?php
require_once '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Consulta para obtener tareas asociadas a productos en producción
$sql = "SELECT 
            p.nombre_producto,
            e.id AS id_empleado,
            u_empleado.nombre AS empleado,
            u_asignador.nombre AS asignador,
            t.descripcion,
            t.fecha_asignacion,
            t.fecha_limite,
            t.estado
        FROM tareas t
        JOIN productos p ON t.id_producto = p.id
        JOIN empleados e ON t.id_empleado = e.id
        JOIN usuarios u_empleado ON e.id_usuario = u_empleado.id
        LEFT JOIN usuarios u_asignador ON t.id_usuario_asignador = u_asignador.id
        WHERE p.estado = 'En Proceso'
        ORDER BY p.nombre_producto, t.fecha_asignacion DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Productos en Producción</title>
        <link rel="stylesheet" href="../../css/jefePlanta/productosEnProcesoJefePlanta.css">

</head>
<body>
    <div class="contenido-principal">
        <h2>Productos en Producción</h2>

        <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Empleado</th>
                <th>Asignado por</th>
                <th>Descripción</th>
                <th>Fecha Asignación</th>
                <th>Fecha Límite</th>
                <th>Estado</th>
            </tr>
            <?php while($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre_producto']) ?></td>
                <td><?= htmlspecialchars($row['empleado']) ?></td>
                <td><?= htmlspecialchars($row['asignador'] ?? 'Desconocido') ?></td>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td><?= htmlspecialchars($row['fecha_asignacion']) ?></td>
                <td><?= htmlspecialchars($row['fecha_limite']) ?></td>
                <td><?= htmlspecialchars($row['estado']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>No hay tareas asignadas a productos en producción actualmente.</p>
        <?php endif; ?>
    </div>
</body>

</html>
