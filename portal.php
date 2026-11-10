<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

include 'inicial.php';
?>

<main>
    <section class="banner-hero">
        <div class="hero-contenido">
            <span class="subtitulo">CENTRO MÉDICO DE RIVADAVIA</span>
            <h2>PORTAL DE SALUD</h2>
            <p>Gestioná tus consultas, consultá tus turnos y actualizá tus datos personales en un solo lugar.</p>
            
        </div>
        <div class="hero-imagen">
            <img src="img/logo.png" alt="Logo Medical">
        </div>
    </section>

    <section class="sobre-nosotros" style="margin-top: 30px;">
        <h3>SOBRE NOSOTROS</h3>
        <p>En Centro Médico Central la excelencia médica es nuestra prioridad. Cuidamos cada detalle de tu atención para asegurar un servicio rápido, transparente y de máxima calidad profesional.</p>
    </section>
</main>

<?php include 'footer.php'; ?>