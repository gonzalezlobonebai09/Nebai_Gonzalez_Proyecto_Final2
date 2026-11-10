<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$busqueda = trim($_GET['buscar'] ?? '');

if ($busqueda !== '') {
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE archivado_en IS NULL AND (nombre LIKE :b OR apellido LIKE :b OR dni LIKE :b OR email LIKE :b)");
    $stmt->execute(['b' => "%$busqueda%"]);
} else {
    $stmt = $conexion->query("SELECT * FROM usuarios WHERE archivado_en IS NULL");
}
$usuarios = $stmt->fetchAll();

include 'inicial.php';
?>

<main>
    <div class="card card-wide">
        <h2>Panel Administrativo - Usuarios Activos</h2>

        <form method="GET" action="admin_usuarios.php" style="margin-bottom: 15px; display: flex; gap: 10px;">
            <input type="text" name="buscar" placeholder="Buscar por Nombre, DNI o Email" value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="btn" style="width: auto; padding: 8px 15px;">Buscar</button>
        </form>

        <div style="margin-bottom: 15px;">
            <a href="usuarios_archivados.php" class="btn-link">Ver Usuarios Archivados</a> | 
            <a href="panel.php" class="btn-link">Volver al Panel</a>
        </div>

        <table class="tabla-custom">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI (Usuario)</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['dni']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['rol']) ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?= $u['id'] ?>" class="btn-link">Editar</a> | 
                        <a href="archivar_usuario.php?id=<?= $u['id'] ?>" class="btn-link link-eliminar" onclick="return confirm('¿Archivar este usuario?')">Archivar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No se encontraron usuarios activos.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>