<?php
session_start();

$conn = new mysqli("localhost", "root", "", "manufex");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    if ($correo != '' && $contraseña != '') {
        $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            $_SESSION['usuario'] = $usuario;

            switch ($usuario['rol']) {
                case 'Gerente':
                    header('Location: roles/gerente/dashboard.php'); break;
                case 'Supervisor':
                    header('Location: roles/supervisor/dashboard.php'); break;
                case 'Jefe de Produccion':
                    header('Location: roles/jefeProduccion/dashboard.php'); break;
                case 'Jefe de Planta':
                    header('Location: roles/jefePlanta/dashboard.php'); break;
                case 'Operario':
                    header('Location: roles/operario/dashboard.php'); break;
                case 'Recursos Humanos':
                    header('Location: roles/recursosHumanos/dashboard.php'); break;
                case 'Tesorero':
                    header('Location: roles/tesorero/dashboard.php'); break;
                case 'Obrero':
                    header('Location: roles/obrero/dashboard.php'); break;
                default:
                    echo "Rol no reconocido.";
            }

            exit;
        } else {
            echo "<p style='color:red;'>Correo o contraseña incorrectos.</p>";
        }
    } else {
        echo "<p style='color:red;'>Por favor completa todos los campos.</p>";
    }
}
?>
