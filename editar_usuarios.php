<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$id = $_GET['id'] ?? 0;
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id AND archivado_en IS NULL");
$stmt->execute(['id' => $id]);
$u = $stmt->fetch();

if (!$u) {
    header('Location: admin_usuarios.php');
    exit;
}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $email = trim($_POST['email']);

    try {
        $update = $conexion->prepare("UPDATE usuarios SET nombre = :nom, apellido = :ape, dni = :dni, email = :email WHERE id = :id");
        $update->execute(['nom' => $nombre, 'ape' => $apellido, 'dni' => $dni, 'email' => $email, 'id' => $id]);
        header('Location: admin_usuarios.php');
        exit;
    } catch (PDOException $e) {
        $mensaje = 'Error al actualizar los datos (DNI o email duplicado).';
    }
}

include 'inicial.php';
?>

<main>
    <div class="card">
        <h2>Editar Usuario</h2>
        <?php if ($mensaje): ?>
            <div class="alerta alerta-error"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group"><label>Nombre:</label><input type="text" name="nombre" value="<?= htmlspecialchars($u['nombre']) ?>" required></div>
            <div class="form-group"><label>Apellido:</label><input type="text" name="apellido" value="<?= htmlspecialchars($u['apellido']) ?>" required></div>
            <div class="form-group"><label>DNI:</label><input type="text" name="dni" value="<?= htmlspecialchars($u['dni']) ?>" required></div>
            <div class="form-group"><label>Email:</label><input type="email" name="email" value="<?= htmlspecialchars($u['email']) ?>" required></div>
            <button type="submit" class="btn">Guardar Cambios</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>