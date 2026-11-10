 <?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$id = $_GET['id'] ?? 0;

$stmt = $conexion->prepare("UPDATE usuarios SET archivado_en = NULL WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: usuarios_archivados.php');
exit;
?>