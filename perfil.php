<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($nombre) || empty($apellido) || empty($dni) || empty($email)) {
        $mensaje = 'Todos los campos son obligatorios.';
        $tipo_mensaje = 'error';
    } else {
        try {
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre = :nom, apellido = :ape, dni = :dni, email = :email WHERE id = :id");
            $stmt->execute([
                'nom' => $nombre,
                'ape' => $apellido,
                'dni' => $dni,
                'email' => $email,
                'id' => $_SESSION['usuario_id']
            ]);

            $mensaje = 'Tus datos se actualizaron correctamente.';
            $tipo_mensaje = 'exito';
        } catch (PDOException $e) {
            $mensaje = 'Error al actualizar los datos (el DNI o Email ya existe).';
            $tipo_mensaje = 'error';
        }
    }
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

include 'inicial.php';
?>

<main>
    <div class="card">
        <h2>Mis Datos Personales</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta alerta-<?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form action="perfil.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
            </div>

            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($usuario['dni']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </div>

            <button type="submit" class="btn">Guardar Cambios</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>