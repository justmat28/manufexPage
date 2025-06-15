<?php 
session_start();
include '../../baseDatos/database.php';

$resultadoMensaje = "";
$claseMensaje = "";

// Validar que vengan los datos necesarios
if (!isset($_POST['id_empleado'], $_POST['descripcion'], $_POST['fecha_limite'])) {
    $resultadoMensaje = "Error: Faltan datos en el formulario.";
    $claseMensaje = "danger";
} else {
    $id_empleado = $_POST['id_empleado'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
    $fecha_asignacion = date('Y-m-d');

    // Obtener ID del usuario que asigna
    if (!isset($_SESSION['usuario']['id'])) {
        $resultadoMensaje = "Error: No hay sesión de usuario.";
        $claseMensaje = "danger";
    } else {
        $id_usuario_asignador = $_SESSION['usuario']['id'];
        $id_producto = isset($_POST['id_producto']) && $_POST['id_producto'] !== "" ? $_POST['id_producto'] : null;

        $sql = "INSERT INTO tareas (id_empleado, id_producto, descripcion, fecha_asignacion, fecha_limite, estado, id_usuario_asignador)
                VALUES (?, ?, ?, ?, ?, 'Pendiente', ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iisssi", $id_empleado, $id_producto, $descripcion, $fecha_asignacion, $fecha_limite, $id_usuario_asignador);

        if ($stmt->execute()) {
            $resultadoMensaje = "Tarea asignada correctamente.";
            $claseMensaje = "success";

            // Si hay producto, actualizar su estado
            if ($id_producto) {
                $updateProducto = "UPDATE productos SET estado = 'En Proceso' WHERE id = ?";
                $stmtProducto = $conexion->prepare($updateProducto);
                $stmtProducto->bind_param("i", $id_producto);
                $stmtProducto->execute();
            }
        } else {
            $resultadoMensaje = "Error al asignar la tarea.";
            $claseMensaje = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Asignación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/jefeProduccion/guardarTareaJefeProduccion.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4 text-center">
            <h2 class="mb-4">Resultado de la Asignación</h2>
            <div class="alert alert-<?= $claseMensaje ?>" role="alert">
                <?= $resultadoMensaje ?>
            </div>
            <a href="asignarTareasProduccion.php" class="btn btn-outline-success mt-3">Volver a Asignar otra Tarea</a>
        </div>
    </div>
</body>
</html>
