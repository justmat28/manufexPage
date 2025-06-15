<?php
session_start();
include '../../baseDatos/database.php';
include('barraNavegacion.php');

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    echo "Error: sesión no iniciada.";
    exit;
}

$usuario = $_SESSION['usuario'];
$usuario_id = $usuario['id'];

// Obtener planta (área) desde la tabla empleados
$sql_planta = "SELECT area FROM empleados WHERE id_usuario = $usuario_id LIMIT 1";
$result_planta = $conexion->query($sql_planta);

if ($result_planta->num_rows > 0) {
    $fila = $result_planta->fetch_assoc();
    $planta = $fila['area'];
} else {
    echo "Error: No se encontró la planta del usuario.";
    exit;
}

// Buscar operarios y obreros de la misma planta
$sql = "SELECT u.id, u.nombre, u.rol FROM usuarios u
        JOIN empleados e ON u.id = e.id_usuario
        WHERE (u.rol = 'Operario' OR u.rol = 'Obrero')
        AND e.area = '$planta'";

$resultado = $conexion->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Enviar Mensajes</title>
    <link rel="stylesheet" href="../../css/jefePlanta/enviarMensajeJefePlanta.css">
</head>
<body>
    <div class="contenido-mensaje">
        <h2>Enviar mensaje a Operarios y Obreros de tu planta</h2>
        <form action="procesarMensaje.php" method="POST">
            <label>Selecciona destinatarios:</label><br>
            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<input type="checkbox" name="destinatarios[]" value="' . $fila['id'] . '"> ' . $fila['nombre'] . ' (' . $fila['rol'] . ')<br>';
                }
            } else {
                echo "<p>No hay operarios ni obreros en tu planta.</p>";
            }
            ?>
            <label>Mensaje:</label>
            <textarea name="mensaje" rows="5" required></textarea>
            <input type="submit" value="Enviar Mensaje">
        </form>
    </div>
</body>
</html>

