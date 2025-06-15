<?php 
session_start();
require_once '../../baseDatos/database.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Gerente</title>
    <link rel="stylesheet" href="../../css/gerente/gerente.css">
</head>
<body>
    <?php include 'barraNavegacion.php'; ?>

    <div class="contenedor-bienvenida">
        <h2>Bienvenido, Gerente.</h2>
        <p>Has iniciado sesión como Gerente. Aquí puedes ver la información relevante de tus empleados.</p>
    </div>
</body>
</html>
