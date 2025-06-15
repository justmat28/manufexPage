<link rel="stylesheet" href="../../css/operario/barraNavegacionOperario.css">

<nav class="barra-superior">
    <div class="lado-izquierdo">
        <button class="hamburguesa" onclick="toggleMenu()">☰</button>
        <a href="dashboard.php">
            <img src="../../images/logoEmpresa.png" alt="Logo" class="logo-img">
        </a>
    </div>

    <div class="menu-izquierdo" id="navMenu">
        <a href="dashboard.php">Inicio</a>
        <a href="tareasAsignadas.php">Mis Tareas</a>
        <a href="registrarProgreso.php">Registrar Progreso</a>
        <a href="enviarReporteFallo.php">Reportar Fallo</a>
        <a href="verMensajes.php">Ver Mensajes</a>
        <a href="verHorario.php">Ver Horario</a>
        <a href="verCharlas.php">Charlas y Talleres</a>
        <a href="../../logout.php">Cerrar Sesión</a>
    </div>

    <div class="perfil" onclick="toggleDropdown()">
        <img src="../../images/fotoPerfil.png" alt="Perfil" class="imagen-perfil">
        <div class="menu-perfil" id="dropdownMenu">
            <a href="../../logout.php">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<script>
function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("show");
}

function toggleDropdown() {
    document.getElementById("dropdownMenu").classList.toggle("show");
}
</script>
