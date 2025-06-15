<link rel="stylesheet" href="../../css/supervisor/barraNavegacionSupervisor.css">

<nav class="barra-superior">
    <div class="lado-izquierdo">
        <button class="hamburguesa" onclick="toggleMenu()">☰</button>
        <a href="dashboard.php">
            <img src="../../images/logoEmpresa.png" alt="Logo" class="logo-img">
        </a>
    </div>

    <div class="menu-izquierdo" id="navMenu">
        <a href="dashboard.php">Inicio</a>
        <a href="asignarTareasProduccion.php">Asignar Tareas</a>
        <a href="faltaPersonal.php">Reportar Falta de Personal</a>
        <a href="productividad.php">Reporte de Productividad</a>
        <a href="mensajes.php">Enviar Mensajes</a>
        <a href="informes.php">Informe a Recursos Humanos</a>
        <a href="mensajesRecibidos.php">Ver mensajes de operarios</a>
        <a href="verCharlas.php">Charlas y Talleres</a>
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
