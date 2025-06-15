<?php
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Obtener empleados excepto Gerente
$query = "SELECT e.id, u.nombre 
          FROM empleados e 
          JOIN usuarios u ON e.id_usuario = u.id 
          WHERE u.rol != 'Gerente'";
$result = mysqli_query($conexion, $query);
?>

<h2>Crear Informe sobre Empleado</h2>
<form action="procesarInformeEmpleado.php" method="POST">
    <label for="empleado">Empleado:</label>
    <select name="empleado_id" required>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="contenido">Contenido del Informe:</label><br>
    <textarea name="contenido" rows="5" cols="50" required></textarea><br>

    <input type="submit" value="Enviar">
</form>
