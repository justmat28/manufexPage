<?php 
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Obtener reportes tipo 'Informe Supervisor' y 'Reporte Productividad'
$query = "
    SELECT r.fecha, r.contenido, r.tipo_reporte, u.nombre
    FROM reportes r
    JOIN empleados e ON r.id_empleado = e.id
    JOIN usuarios u ON e.id_usuario = u.id
    WHERE r.tipo_reporte IN ('Informe Supervisor', 'Reporte Productividad')
    ORDER BY r.fecha DESC
";

$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes del Supervisor</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/recursosHumanos/verReportesSupervisor.css">
</head>
<body>
    <main>
        <div class="contenedor-bienvenida">
            <h2>Reportes enviados por el Supervisor</h2>
            <table border="1">
                <tr>
                    <th>Fecha</th>
                    <th>Empleado</th>
                    <th>Tipo de Reporte</th>
                    <th>Contenido</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['fecha'] ?></td>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['tipo_reporte'] ?></td>
                        <td><?= $row['contenido'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>
</body>
</html>
