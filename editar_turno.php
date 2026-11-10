<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$id_turno = $_GET['id'] ?? 0;

$stmt = $conexion->prepare("SELECT * FROM turnos WHERE id = :id AND usuario_id = :uid");
$stmt->execute(['id' => $id_turno, 'uid' => $_SESSION['usuario_id']]);
$turno = $stmt->fetch();

if (!$turno) {
    header('Location: turnos_sacados.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medico = $_POST['medico'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $update = $conexion->prepare("UPDATE turnos SET medico = :med, fecha = :fec, hora = :hor WHERE id = :id AND usuario_id = :uid");
    $update->execute([
        'med' => $medico,
        'fec' => $fecha,
        'hor' => $hora,
        'id' => $id_turno,
        'uid' => $_SESSION['usuario_id']
    ]);

    header('Location: turnos_sacados.php');
    exit;
}

include 'inicial.php';
?>

<main>
    <div class="card card-wide">
        <h2>Modificar Turno Médico</h2>

        <form method="POST">
            <div class="form-group">
                <label for="medico">Médico / Profesional:</label>
                <select id="medico" name="medico" required>
                    <option value="Dr. Pérez" <?= $turno['medico'] == 'Dr. Pérez' ? 'selected' : '' ?>>Dr. Pérez (Clínica Médica)</option>
                    <option value="Dra. Benítez" <?= $turno['medico'] == 'Dra. Benítez' ? 'selected' : '' ?>>Dra. Benítez (Clínica Médica)</option>
                    <option value="Dra. Gómez" <?= $turno['medico'] == 'Dra. Gómez' ? 'selected' : '' ?>>Dra. Gómez (Pediatría)</option>
                    <option value="Dr. Sánchez" <?= $turno['medico'] == 'Dr. Sánchez' ? 'selected' : '' ?>>Dr. Sánchez (Pediatría)</option>
                    <option value="Dr. Martínez" <?= $turno['medico'] == 'Dr. Martínez' ? 'selected' : '' ?>>Dr. Martínez (Cardiología)</option>
                    <option value="Dra. Rossi" <?= $turno['medico'] == 'Dra. Rossi' ? 'selected' : '' ?>>Dra. Rossi (Cardiología)</option>
                    <option value="Dra. López" <?= $turno['medico'] == 'Dra. López' ? 'selected' : '' ?>>Dra. López (Dermatología)</option>
                    <option value="Dr. Fernández" <?= $turno['medico'] == 'Dr. Fernández' ? 'selected' : '' ?>>Dr. Fernández (Dermatología)</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha">Nueva Fecha:</label>
                    <input type="date" id="fecha" name="fecha" value="<?= $turno['fecha'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="hora">Nuevo Horario:</label>
                    <select id="hora" name="hora" required>
                        <?php 
                        $horarios = ["08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "12:00 AM", "14:00 PM", "15:00 PM", "16:00 PM", "17:00 PM", "18:00 PM"];
                        foreach ($horarios as $h): 
                        ?>
                            <option value="<?= $h ?>" <?= $turno['hora'] == $h ? 'selected' : '' ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn">Guardar Cambios</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>