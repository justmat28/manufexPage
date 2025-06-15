<?php 
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Charla o Taller</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/recursosHumanos/enviarCharla.css">
</head>
<body>
    <main>
        <div class="contenedor-bienvenida">
            <h2>Enviar Charla o Taller</h2>
            <form action="procesarCharla.php" method="POST">
                <label for="tipo">Tipo:</label>
                <select name="tipo" required>
                    <option value="Charla">Charla</option>
                    <option value="Taller">Taller</option>
                </select><br><br>

                <label for="mensaje">Mensaje:</label><br>
                <textarea name="mensaje" rows="5" cols="50" required></textarea><br><br>

                <input type="submit" value="Enviar">
            </form>
        </div>
    </main>
</body>
</html>
