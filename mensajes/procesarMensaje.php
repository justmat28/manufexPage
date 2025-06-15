<?php
session_start();
require_once("../baseDatos/database.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$emisor_id = $_SESSION['usuario_id'];
$receptor_id = $_POST['receptor_id'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO mensajes (emisor_id, receptor_id, mensaje) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $emisor_id, $receptor_id, $mensaje);

if ($stmt->execute()) {
    echo "Mensaje enviado correctamente. <a href='bandejaEntrada.php'>Ver mensajes</a>";
} else {
    echo "Error al enviar mensaje.";
}
?>
