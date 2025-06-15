<?php
session_start();
include '../../baseDatos/database.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informes de Productividad</title>
    <link rel="stylesheet" href="../../css/gerente/informesProductividad.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <h2>Informes de Productividad</h2>

    <?php
    
    $query = "
        SELECT r.fecha, u.nombre AS autor, r.tipo_reporte, r.contenido
        FROM reportes r
        JOIN empleados e ON r.id_empleado = e.id
        JOIN usuarios u ON e.id_usuario = u.id
        WHERE r.tipo_reporte = 'Informe RRHH'
        ORDER BY r.fecha DESC
    ";

    $resultado = mysqli_query($conexion, $query);
    ?>

    <table>
        <tr>
            <th>Fecha:</th>
            <th>Autor:</th>
            <th>Reporte:</th>
        </tr>
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= $fila['fecha'] ?></td>
                    <td><?= $fila['autor'] ?></td>
                    <td><?= $fila['contenido'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No hay informes disponibles.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
