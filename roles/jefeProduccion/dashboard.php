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
    <title>Panel Jefe de Producción</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/jefeProduccion/dashboardJefeProduccion.css"> <!-- Estilo propio -->
</head>
<body>
    <?php include 'barraNavegacion.php'; ?> <!-- Barra propia de jefeProduccion -->

    <main>
        <div class="contenedor-bienvenida">
            <h2>Bienvenido, Jefe de Producción.</h2>
            <p>Has iniciado sesión como Jefe de Producción. Aquí puedes gestionar tareas de producción y comunicarte con tu equipo.</p>
        </div>
    </main>
</body>
</html>
