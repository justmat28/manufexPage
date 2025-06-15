<?php
session_start();
include '../../baseDatos/database.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.html");
    exit();
}

// Validar datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['receptor_id'], $_POST['contenido'])) {
    $receptor_id = intval($_POST['receptor_id']);
    $contenido = trim($_POST['contenido']);
    $emisor_id = $_SESSION['usuario_id'];
    $fecha_envio = date("Y-m-d H:i:s");

    // Insertar el mensaje en la base de datos
    $sql = "INSERT INTO mensajes (emisor_id, receptor_id, contenido, fecha_envio)
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiss", $emisor_id, $receptor_id, $contenido, $fecha_envio);
        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: mensajes.php?enviado=1");
            exit();
        } else {
            echo "Error al enviar el mensaje: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta.";
    }
} else {
    echo "Datos incompletos.";
}
?>
