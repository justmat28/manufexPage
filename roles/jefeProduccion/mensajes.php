<?php
session_start();
include '../../baseDatos/database.php';
include 'barraNavegacion.php';

$sql = "SELECT e.id, u.nombre, u.rol, e.area FROM empleados e
        JOIN usuarios u ON e.id_usuario = u.id
        WHERE u.rol NOT IN ('Recursos Humanos', 'Tesorero')";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Mensaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/jefeProduccion/mensajesJefeProduccion.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-success mb-4">Enviar Mensaje</h2>
        <div class="card shadow p-4">
            <form action="procesarMensaje.php" method="POST">
                <div class="mb-3">
                    <label for="receptor_id" class="form-label">Selecciona destinatario:</label>
                    <select name="receptor_id" id="receptor_id" class="form-select" required>
                        <?php while($row = $resultado->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['nombre'] . " - " . $row['rol'] . " - " . $row['area']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Mensaje:</label>
                    <textarea name="contenido" id="contenido" class="form-control" rows="5" required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
