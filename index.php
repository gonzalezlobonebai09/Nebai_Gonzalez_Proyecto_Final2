<?php
session_start();
require_once __DIR__ . '/conexion.php';

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_ingresada = trim($_POST['password'] ?? '');
    $confirmar_password = trim($_POST['confirmar_password'] ?? '');

    if (empty($nombre) || empty($apellido) || empty($dni) || empty($email) || empty($password_ingresada) || empty($confirmar_password)) {
        $mensaje = 'Por favor, completa todos los campos.';
        $tipo_mensaje = 'error';
    } elseif ($password_ingresada !== $confirmar_password) {
        $mensaje = 'Las contraseñas no coinciden. Verificalas.';
        $tipo_mensaje = 'error';
    } else {
        try {
            $password_hash = password_hash($password_ingresada, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, apellido, dni, email, password, rol) VALUES (:nombre, :apellido, :dni, :email, :password, 'usuario')";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'dni' => $dni,
                'email' => $email,
                'password' => $password_hash
            ]);

            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $mensaje = 'El DNI o Email ya se encuentran registrados.';
            } else {
                error_log($e->getMessage());
                $mensaje = 'Error al registrar la cuenta.';
            }
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
    <title>Registro - Centro Médico de Rivadavia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="body-login">

    <div class="card-login">
        <h2 class="titulo-login">Crear Cuenta</h2>
        <p class="subtitulo-login">Portal de Turnos Médicos</p>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta alerta-<?= $tipo_mensaje ?> alerta-login">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" class="form-login">
            <div class="input-rounded-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" placeholder="Ej: Carolina" required>
            </div>

            <div class="input-rounded-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" placeholder="Ej: Flores" required>
            </div>

            <div class="input-rounded-group">
                <label>Usuario:</label>
                <input type="text" name="dni" placeholder="Ej: DNI: 49803123" required>
            </div>

            <div class="input-rounded-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" placeholder="Ej: caro1999@gmail.com" required>
            </div>

            <div class="input-rounded-group">
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="input-rounded-group">
                <label>Confirmar Contraseña:</label>
                <input type="password" name="confirmar_password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-red-rounded">REGISTRARME</button>
        </form>

        <p class="pie-login">
            <a href="login.php" class="link-login">¿Ya tenés cuenta? Iniciá sesión acá</a>
        </p>
    </div>

</body>
</html>