<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Médico de Rivadavia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header-principal">
        <div class="header-container">
            <h1 class="logo">Centro Médico de Rivadavia</h1>
            <nav class="nav-menu">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="portal.php" class="nav-link">Inicio</a>
                    <a href="perfil.php" class="nav-link">Mis Datos</a>
                    <a href="turnos.php" class="nav-link">Sacar Turno</a>
                    <a href="turnos_sacados.php" class="nav-link">Turnos Sacados</a>
                    <a href="cerrar_sesion.php" class="nav-link nav-link-salir">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Iniciar Sesión</a>
                    <a href="index.php" class="nav-link">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>