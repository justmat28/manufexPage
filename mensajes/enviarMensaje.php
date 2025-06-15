<?php
session_start();
require_once("../baseDatos/database.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

// Obtener lista de usuarios (menos el actual)
$sql = "SELECT id, nombre FROM usuarios WHERE id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enviar Mensaje</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Enviar Mensaje</h2>
    <form action="procesarMensaje.php" method="post">
        <label>Destinatario:</label>
        <select name="receptor_id" required>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nombre']) ?></option>
            <?php } ?>
        </select><br><br>

        <label>Mensaje:</label><br>
        <textarea name="mensaje" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
