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
    <title>Panel Jefe de Planta</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/jefePlanta/dashboardJefePlanta.css"> <!-- Asegúrate de que este exista -->
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <main>
        <div class="contenedor-bienvenida">
            <h2>Bienvenido, Jefe de Planta.</h2>
            <p>Has iniciado sesión como Jefe de Planta. Aquí puedes gestionar la información de tu planta.</p>
        </div>
    </main>
</body>
</html>
