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
    <title>Panel de Empleado</title>
    <link rel="stylesheet" href="../../css/obrero/dashboardObrero.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <div class="contenedor-bienvenida">
        <h2>Bienvenido empleado.</h2>
        <p>Has iniciado sesión como Empleado. Aquí puedes ver tu información relevante.</p>
    </div>
</body>
</html>
