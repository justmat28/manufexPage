<link rel="stylesheet" href="../../css/jefeProduccion/barraNavegacionJefeProduccion.css">

<nav class="barra-superior">
    <div class="lado-izquierdo">
        <button class="hamburguesa" onclick="toggleMenu()">☰</button>
        <a href="dashboard.php">
            <img src="../../images/logoEmpresa.png" alt="Logo" class="logo-img">
        </a>
    </div>

    <div class="menu-izquierdo" id="sidebar">
        <a href="dashboard.php">Inicio</a>
        <a href="asignarTareasProduccion.php">Asignar Tareas</a>
        <a href="productosEnProduccion.php">Productos</a>
        <a href="mensajes.php">Enviar Mensaje</a>
        <a href="mensajesRecibidos.php">Mensajes de Operarios</a>
        <a href="verFaltaPersonal.php">Falta de Personal</a>
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
    document.getElementById("sidebar").classList.toggle("show");
}

function toggleDropdown() {
    document.getElementById("dropdownMenu").classList.toggle("show");
}
</script>
