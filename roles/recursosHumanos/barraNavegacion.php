<link rel="stylesheet" href="../../css/recursosHumanos/barraNavegacionRecursosHumanos.css">

<nav class="barra-superior">
    <div class="lado-izquierdo">
        <button class="hamburguesa" onclick="toggleMenu()">☰</button>
        <a href="dashboard.php">
            <img src="../../images/logoEmpresa.png" alt="Logo" class="logo-img">
        </a>
    </div>

    <div class="menu-izquierdo" id="navMenu">
        <a href="dashboard.php">Inicio</a>
        <a href="verReportesSupervisor.php">Ver Reportes</a>
        <a href="crearInformeEmpleado.php">CrearInforme de Empleado</a>
        <a href="enviarCharla.php">Charlas y Talleres</a>
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
