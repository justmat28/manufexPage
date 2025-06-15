<?php
session_start();
include '../../baseDatos/database.php';

$id_tarea = $_POST['id_tarea'];
$estado = $_POST['estado'];

$sql = "UPDATE tareas SET estado = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $estado, $id_tarea);
$stmt->execute();

header("Location: registrarProgreso.php");
exit();
