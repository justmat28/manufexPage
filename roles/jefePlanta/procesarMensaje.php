<?php
session_start();
include("../../baseDatos/database.php");

if (!isset($_SESSION['usuario'])) {
    echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='../../css/jefePlanta/procesarMensajeJefePlanta.css'></head><body>";
    echo "<div class='mensaje-error'>Error: sesión no iniciada.</div></body></html>";
    exit;
}

$usuario = $_SESSION['usuario'];
$emisor_id_usuario = $usuario['id'];

// Obtener ID del empleado asociado
$sql_emisor = "SELECT id FROM empleados WHERE id_usuario = $emisor_id_usuario LIMIT 1";
$result_emisor = $conexion->query($sql_emisor);

if ($result_emisor->num_rows === 0) {
    echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='../../css/jefePlanta/procesarMensajeJefePlanta.css'></head><body>";
    echo "<div class='mensaje-error'>Error: No se encontró el empleado asociado al usuario.</div></body></html>";
    exit;
}

$emisor_id_empleado = $result_emisor->fetch_assoc()['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinatarios = $_POST['destinatarios'];
    $mensaje = $_POST['mensaje'];
    $fecha = date('Y-m-d H:i:s');

    $errores = 0;

    foreach ($destinatarios as $destinatario_usuario_id) {
        $sql_receptor = "SELECT id FROM empleados WHERE id_usuario = $destinatario_usuario_id LIMIT 1";
        $result_receptor = $conexion->query($sql_receptor);

        if ($result_receptor->num_rows > 0) {
            $receptor_id_empleado = $result_receptor->fetch_assoc()['id'];

            $stmt = $conexion->prepare("INSERT INTO mensajes (emisor_id, receptor_id, contenido, fecha_envio) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $emisor_id_empleado, $receptor_id_empleado, $mensaje, $fecha);
            if (!$stmt->execute()) {
                $errores++;
            }
        } else {
            $errores++;
        }
    }

    echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='../../css/jefePlanta/procesarMensajeJefePlanta.css'></head><body>";
    if ($errores === 0) {
        echo "<div class='mensaje-exito'>Mensaje enviado a todos los destinatarios seleccionados.</div>";
    } else {
        echo "<div class='mensaje-error'>Algunos mensajes no pudieron enviarse.</div>";
    }
    echo "<a href='enviarMensaje.php' class='boton-volver'>← Volver</a></body></html>";
}
?>
