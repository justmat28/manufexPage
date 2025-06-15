<?php
session_start();
require_once("../baseDatos/database.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT m.mensaje, m.fecha_envio, u.nombre AS emisor
        FROM mensajes m
        JOIN usuarios u ON m.emisor_id = u.id
        WHERE m.receptor_id = ?
        ORDER BY m.fecha_envio DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bandeja de Entrada</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Mensajes Recibidos</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><strong><?= htmlspecialchars($row['emisor']) ?></strong> (<?= $row['fecha_envio'] ?>):<br>
            <?= nl2br(htmlspecialchars($row['mensaje'])) ?></li><br>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No tienes mensajes.</p>
    <?php endif; ?>
</body>
</html>
