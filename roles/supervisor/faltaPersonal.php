<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Acceso denegado.";
    exit;
}

include('barraNavegacion.php');
include('funciones.php');
include('../../baseDatos/database.php');

$usuario = $_SESSION['usuario'];
$id_usuario_emisor = $usuario['id'];

$consulta_empleado = $conexion->prepare("SELECT id FROM empleados WHERE id_usuario = ?");
$consulta_empleado->bind_param("i", $id_usuario_emisor);
$consulta_empleado->execute();
$resultado_empleado = $consulta_empleado->get_result();
$empleado_emisor = $resultado_empleado->fetch_assoc();

if (!$empleado_emisor) {
    echo "No se encontró al supervisor en la base de datos.";
    exit;
}

$id_empleado_emisor = $empleado_emisor['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Falta de Personal</title>
    <link rel="stylesheet" href="../../css/estilosGenerales.css">
    <link rel="stylesheet" href="../../css/supervisor/faltaPersonal.css">
</head>
<body>
<main class="contenedor-falta-personal">
    <h2>Reportar falta de personal</h2>

    <form method="POST" class="formulario-rol">
        <label>Selecciona tipo de trabajador:</label>
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

        echo '<form method="POST" class="formulario-notificacion">';
        echo '<input type="hidden" name="rol" value="' . htmlspecialchars($rol) . '">';
        echo '<label>Selecciona empleados:</label><br>';

        while ($row = $empleados->fetch_assoc()) {
            echo "<label><input type='checkbox' name='empleados[]' value='{$row['id']}'> " . 
                 htmlspecialchars($row['nombre']) . " - " . htmlspecialchars($row['area']) . "</label><br>";
        }

        echo '<label>Planta de destino:</label>';
        echo '<select name="planta" required>
                <option value="Planta 1">Planta 1</option>
                <option value="Planta 2">Planta 2</option>
              </select><br>';
        echo '<input type="submit" name="enviar" value="Notificar">';
        echo '</form>';
    }

    if (isset($_POST['enviar'])) {
        if (!isset($_POST['empleados']) || empty($_POST['empleados'])) {
            echo "<p class='mensaje error'>Debes seleccionar al menos un empleado.</p>";
        } else {
            $empleados = $_POST['empleados'];
            $planta = $_POST['planta'];
            $fecha_hora = date("Y-m-d H:i:s");
            $nombre_supervisor = $usuario['nombre'];

            foreach ($empleados as $id_receptor) {
                $mensaje = "Falta de personal reportada por $nombre_supervisor. Preséntate en $planta.";
                $sql_insert = $conexion->prepare("INSERT INTO mensajes (emisor_id, receptor_id, contenido, fecha_envio) VALUES (?, ?, ?, ?)");
                $sql_insert->bind_param("iiss", $id_empleado_emisor, $id_receptor, $mensaje, $fecha_hora);
                $sql_insert->execute();
            }

            echo "<p class='mensaje exito'>Notificación enviada correctamente.</p>";
        }
    }
    ?>
</main>
</body>
</html>
