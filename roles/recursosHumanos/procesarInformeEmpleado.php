<?php
session_start();
include '../../baseDatos/database.php';

$empleado_id = $_POST['empleado_id'];
$contenido = $_POST['contenido'];

// Escapar valores para evitar inyección SQL
$empleado_id = intval($empleado_id);
$contenido = mysqli_real_escape_string($conexion, $contenido);

mysqli_query($conexion, "
    INSERT INTO reportes (id_empleado, tipo_reporte, fecha, contenido)
    VALUES ($empleado_id, 'Informe RRHH', CURDATE(), '$contenido')
");

echo "Informe enviado al gerente.";
?>
