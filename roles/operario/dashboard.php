<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.html");
    exit();
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Operario</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/operario/dashboardOperario.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <main>
        <div class="contenedor-bienvenida">
            <h2>Bienvenido, Operario.</h2>
            <p>Has iniciado sesión como Operario. Desde aquí puedes registrar tu progreso, reportar fallos y revisar tus mensajes.</p>
        </div>
    </main>
</body>
</html>
