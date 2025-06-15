<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.html");
    exit();
}
include '../../baseDatos/database.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Recursos Humanos</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/recursosHumanos/dashboardRecursosHumanos.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <main>
        <div class="contenedor-bienvenida">
            <h2>Bienvenido, Recursos Humanos</h2>
            <p>Desde aquí puedes enviar charlas o talleres, crear informes de empleados e inspeccionar los reportes del supervisor.</p>
        </div>
    </main>
</body>
</html>
