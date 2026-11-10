<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$id_turno = $_GET['id'] ?? 0;

$stmt = $conexion->prepare("DELETE FROM turnos WHERE id = :id AND usuario_id = :uid");
$stmt->execute(['id' => $id_turno, 'uid' => $_SESSION['usuario_id']]);

header('Location: turnos_sacados.php');
exit;
?>