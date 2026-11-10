<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$stmt = $conexion->prepare("SELECT * FROM turnos WHERE usuario_id = :uid ORDER BY fecha ASC");
$stmt->execute(['uid' => $_SESSION['usuario_id']]);
$turnos = $stmt->fetchAll();

include 'inicial.php';
?>

<main>
    <div class="card card-wide">
        <h2>Turnos Sacados</h2>
        
        <div style="margin-bottom: 15px;">
            <a href="menu.php" class="btn-link">Volver al Menú Principal</a> | 
            <a href="turnos.php" class="btn-link">Sacar un Nuevo Turno</a>
        </div>

        <table class="tabla-custom">
            <thead>
                <tr>
                    <th>Especialidad</th>
                    <th>Médico</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['especialidad']) ?></td>
                    <td><?= htmlspecialchars($t['medico']) ?></td>
                    <td><?= htmlspecialchars($t['fecha']) ?></td>
                    <td><?= htmlspecialchars($t['hora']) ?></td>
                    <td>
                        <a href="editar_turno.php?id=<?= $t['id'] ?>" class="btn-link">Editar</a> | 
                        <a href="eliminar_turno.php?id=<?= $t['id'] ?>" class="btn-link link-eliminar" onclick="return confirm('¿Seguro que querés cancelar este turno?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($turnos)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No tenés ningún turno reservado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.php'; ?>