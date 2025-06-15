<?php
include("../../baseDatos/database.php");

function obtenerEmpleadosPorRol($rol) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT empleados.id, usuarios.nombre, empleados.area, usuarios.rol 
                                FROM empleados 
                                INNER JOIN usuarios ON empleados.id_usuario = usuarios.id 
                                WHERE usuarios.rol = ?");
    $stmt->bind_param("s", $rol);
    $stmt->execute();
    return $stmt->get_result();
}

function obtenerTodosMenosRRHHTesorerosYSupervisores() {
    global $conexion;
    $query = "SELECT empleados.id, usuarios.nombre, empleados.area, usuarios.rol 
              FROM empleados 
              INNER JOIN usuarios ON empleados.id_usuario = usuarios.id 
              WHERE usuarios.rol NOT IN ('Recursos Humanos', 'Tesorero', 'Supervisor')";
    return $conexion->query($query);
}
?>
