<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/gerente/barraNavegacionGerente.css">

<script>
    function toggleMenu() {
        const menu = document.getElementById("menuIzquierdo");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    function togglePerfilMenu() {
        const perfilMenu = document.getElementById("menuPerfil");
        perfilMenu.style.display = (perfilMenu.style.display === "block") ? "none" : "block";
    }
</script>

<div class="barra-superior"> 
    <div class="lado-izquierdo">
        <button class="hamburguesa" onclick="toggleMenu()">☰</button>
        <div class="logo">
            <a href="dashboard.php">
                <img src="../../images/logoEmpresa.png" alt="Logo" class="logo-img">
            </a>
        </div>
    </div>

    <div class="perfil" onclick="togglePerfilMenu()">
        <img src="../../images/fotoPerfil.png" alt="Perfil" class="imagen-perfil">
        <div class="menu-perfil" id="menuPerfil">
            <a href="../../logout.php">Cerrar sesión</a>
        </div>
    </div>
</div>

<div class="menu-izquierdo" id="menuIzquierdo">
    <a href="dashboard.php">Inicio</a>
    <a href="tareasAsignadas.php">Tareas Asignadas</a>
    <a href="registrarProgreso.php">Registrar Progreso</a>
    <a href="verEmpleados.php">Informar falta de personal</a>
    <a href="verHorario.php">Horario</a>
    <a href="verEmpleados.php">Permisos</a>
</div>
