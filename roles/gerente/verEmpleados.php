<?php
require_once '../../baseDatos/database.php';
include 'barraNavegacion.php';

// Obtener filtros del formulario
$nombre = $_GET['nombre'] ?? '';
$area = $_GET['area'] ?? '';
$sueldo = $_GET['sueldo'] ?? '';
$orden = $_GET['orden'] ?? 'u.nombre ASC';

// Construcción dinámica del query
$query = "SELECT u.nombre, u.rol, e.area, e.sueldo 
          FROM usuarios u
          INNER JOIN empleados e ON u.id = e.id_usuario
          WHERE 1=1";

if (!empty($nombre)) {
    $query .= " AND u.nombre LIKE '%" . $conexion->real_escape_string($nombre) . "%'";
}

if (!empty($area)) {
    $query .= " AND e.area = '" . $conexion->real_escape_string($area) . "'";
}

if (is_numeric($sueldo)) {
    $query .= " AND e.sueldo = " . floatval($sueldo);
}

$query .= " ORDER BY $orden";

$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Empleados</title>
    <link rel="stylesheet" href="../../css/gerente/verEmpleados.css">
</head>
<body>
    <h2>Listado de Empleados</h2>

    <form method="GET">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>">

        <label>Área:</label>
        <input type="text" name="area" value="<?= htmlspecialchars($area) ?>">

        <label>Sueldo:</label>
        <input type="number" name="sueldo" value="<?= htmlspecialchars($sueldo) ?>">

        <label>Ordenar por:</label>
        <select name="orden">
            <option value="u.nombre ASC" <?= $orden === 'u.nombre ASC' ? 'selected' : '' ?>>Nombre A-Z</option>
            <option value="u.nombre DESC" <?= $orden === 'u.nombre DESC' ? 'selected' : '' ?>>Nombre Z-A</option>
            <option value="e.area ASC" <?= $orden === 'e.area ASC' ? 'selected' : '' ?>>Área A-Z</option>
            <option value="e.sueldo ASC" <?= $orden === 'e.sueldo ASC' ? 'selected' : '' ?>>Sueldo Menor a Mayor</option>
            <option value="e.sueldo DESC" <?= $orden === 'e.sueldo DESC' ? 'selected' : '' ?>>Sueldo Mayor a Menor</option>
        </select>

        <button type="submit">Buscar / Filtrar</button>
    </form>

    <br>

    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Área</th>
            <th>Sueldo</th>
        </tr>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($empleado = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                    <td><?= htmlspecialchars($empleado['rol']) ?></td>
                    <td><?= htmlspecialchars($empleado['area']) ?></td>
                    <td>S/.<?= number_format($empleado['sueldo'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No se encontraron empleados.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
