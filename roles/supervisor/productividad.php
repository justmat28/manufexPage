<?php include('barraNavegacion.php'); ?>
<link rel="stylesheet" href="../../css/supervisor/productividad.css">
<?php include('funciones.php'); include('../../baseDatos/database.php'); ?>

<h2>Reporte de Productividad</h2>

<form method="POST">
    <label>Seleccionar empleados:</label><br>
    <?php
    $empleados = obtenerTodosMenosRRHHTesorerosYSupervisores();
    while ($row = $empleados->fetch_assoc()) {
        echo "<div class='checkbox-item'>
                <input type='checkbox' name='empleados[]' value='{$row['id']}'>
                <span>{$row['nombre']} - {$row['area']} ({$row['rol']})</span>
              </div>";
    }
    ?>
    <textarea name="contenido" placeholder="Detalle del reporte de productividad..."></textarea><br>
    <input type="submit" name="enviar" value="Enviar a RRHH">
</form>

<?php
if (isset($_POST['enviar'])) {
    $contenido = $_POST['contenido'];
    $fecha = date("Y-m-d");
    foreach ($_POST['empleados'] as $id) {
        $query = "INSERT INTO reportes (id_empleado, tipo_reporte, fecha, contenido) 
                  VALUES ('$id', 'Reporte Productividad', '$fecha', '$contenido')";
        $conexion->query($query);
    }
    echo "<p class='mensaje-exito'>Reporte enviado a Recursos Humanos.</p>";
}
?>
