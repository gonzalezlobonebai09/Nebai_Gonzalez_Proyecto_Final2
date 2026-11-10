<?php
session_start();
require_once __DIR__ . '/conexion.php';

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = trim($_POST['dni'] ?? '');
    $password_ingresada = trim($_POST['password'] ?? '');

    if (empty($dni) || empty($password_ingresada)) {
        $mensaje = 'Por favor, ingresá tu usuario y contraseña.';
        $tipo_mensaje = 'error';
    } else {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE dni = :dni");
        $stmt->execute(['dni' => $dni]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password_ingresada, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header('Location: portal.php');
            exit;
        } else {
            $mensaje = 'Usuario o contraseña incorrectos.';
            $tipo_mensaje = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Centro Médico Central</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="body-login">

    <div class="card-login">
        <h2 class="titulo-login">Iniciar Sesión</h2>
        <p class="subtitulo-login">Portal de Turnos Médicos</p>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta alerta-<?= $tipo_mensaje ?> alerta-login">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="form-login">
            <div class="input-rounded-group">
                <label>Usuario (DNI):</label>
                <input type="text" name="dni" placeholder="Ej: 49803123" required>
            </div>

            <div class="input-rounded-group">
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-red-rounded">INGRESAR</button>
        </form>

        <p class="pie-login">
            <a href="index.php" class="link-login">¿No tenés cuenta? Registrate acá</a>
        </p>
    </div>

</body>
</html>