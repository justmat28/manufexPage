<?php 
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Verifica que el usuario esté en sesión
if (!isset($_SESSION['usuario'])) {
    die("No has iniciado sesión.");
}

// Obtener el id_usuario desde la sesión
$id_usuario = $_SESSION['usuario']['id'];

// Obtener el id_empleado asociado a ese usuario
$consulta = "SELECT id FROM empleados WHERE id_usuario = $id_usuario";
$result = mysqli_query($conexion, $consulta);
if ($result && $fila = mysqli_fetch_assoc($result)) {
    $id_empleado = $fila['id'];
} else {
    die("No se encontró el empleado correspondiente.");
}

// Obtener charlas y talleres recibidos
$query = "
    SELECT m.fecha_envio, m.contenido, u.nombre AS emisor
    FROM mensajes m
    JOIN empleados e ON m.emisor_id = e.id
    JOIN usuarios u ON e.id_usuario = u.id
    WHERE m.receptor_id = $id_empleado 
    AND (m.contenido LIKE '[Charla]%' OR m.contenido LIKE '[Taller]%')
    ORDER BY m.fecha_envio DESC
";

$resultado = mysqli_query($conexion, $query);
?>
<link rel="stylesheet" href="../../css/supervisor/verCharlas.css">

<div class="contenedor-charlas">
    <h2>Charlas y Talleres recibidos</h2>
    <table class="tabla-charlas">
        <tr>
            <th>Fecha</th>
            <th>Emisor</th>
            <th>Mensaje</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?= $fila['fecha_envio'] ?></td>
                <td><?= $fila['emisor'] ?></td>
                <td><?= $fila['contenido'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
