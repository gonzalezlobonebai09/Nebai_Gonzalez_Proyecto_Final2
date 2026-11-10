<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$stmt = $conexion->query("SELECT * FROM usuarios WHERE archivado_en IS NOT NULL");
$archivados = $stmt->fetchAll();

include 'inicial.php';
?>

<main>
    <div class="card card-wide">
        <h2>Usuarios Archivados</h2>
        <div style="margin-bottom: 15px;">
            <a href="admin_usuarios.php" class="btn-link">Volver a Usuarios Activos</a>
        </div>

        <table class="tabla-custom">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Archivado El</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($archivados as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['dni']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['archivado_en']) ?></td>
                    <td>
                        <a href="reactivar_usuario.php?id=<?= $u['id'] ?>" class="btn-link">Reactivar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($archivados)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay usuarios archivados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>