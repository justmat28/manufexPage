<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.html");
    exit();
}
include('barraNavegacion.php');
include('funciones.php');
include('../../baseDatos/database.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe a Recursos Humanos</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/supervisor/informes.css">
</head>
<body>
<main class="contenedor-informes">
    <h2>Crear informe sobre empleado</h2>
    
    <form method="POST" class="formulario-rol">
        <label>Seleccionar rol:</label>
        <select name="rol" required>
            <option value="Jefe de Produccion">Jefe de Producción</option>
            <option value="Jefe de Planta">Jefe de Planta</option>
            <option value="Operario">Operario</option>
            <option value="Obrero">Obrero</option>
        </select>
        <input type="submit" name="filtrar" value="Cargar empleados">
    </form>

    <?php
    
    if (isset($_POST['filtrar'])) {
        $rol = $_POST['rol'];
        $empleados = obtenerEmpleadosPorRol($rol);

        echo '<form method="POST" class="formulario-informe">';
        echo '<input type="hidden" name="rol_seleccionado" value="' . htmlspecialchars($rol) . '">';
        echo '<label>Seleccionar empleado:</label>';
        echo '<select name="id_empleado" required>';
        while ($row = $empleados->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nombre']} - {$row['area']} ({$row['rol']})</option>";
        }
        echo '</select><br>';
        echo '<label>Contenido del informe:</label>';
        echo '<textarea name="contenido" placeholder="Escribe el informe..." required></textarea><br>';
        echo '<input type="submit" name="enviar_informe" value="Enviar informe">';
        echo '</form>';
    }

    if (isset($_POST['enviar_informe'])) {
        $id = $_POST['id_empleado'];
        $contenido = trim($_POST['contenido']);
        $fecha = date("Y-m-d");

        if ($contenido === '') {
            echo '<p class="error">El contenido del informe no puede estar vacío.</p>';
        } else {
            $query = "INSERT INTO reportes (id_empleado, tipo_reporte, fecha, contenido) 
                      VALUES ('$id', 'Informe Supervisor', '$fecha', '$contenido')";
            if ($conexion->query($query)) {
                echo '<p class="exito">Informe enviado a Recursos Humanos.</p>';
            } else {
                echo '<p class="error">Error al enviar el informe.</p>';
            }
        }
    }
    ?>
</main>
</body>
</html>
