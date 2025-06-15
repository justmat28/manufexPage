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
    <title>Panel Supervisor</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/supervisor/dashboardSupervisor.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <main>
        <div class="contenedor-bienvenida">
            <h2>Bienvenido, Supervisor.</h2>
            <p>Has iniciado sesión como Supervisor. Desde aquí puedes enviar informes a RRHH, asignar tareas y mensajes, reportar faltas de personal y generar reportes de productividad.</p>
        </div>
    </main>
</body>
</html>
