<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medico = $_POST['medico'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';

    if (!empty($medico) && !empty($especialidad) && !empty($fecha) && !empty($hora)) {
        $stmt = $conexion->prepare("INSERT INTO turnos (usuario_id, especialidad, medico, fecha, hora) VALUES (:uid, :esp, :med, :fec, :hor)");
        $stmt->execute([
            'uid' => $_SESSION['usuario_id'],
            'esp' => $especialidad,
            'med' => $medico,
            'fec' => $fecha,
            'hor' => $hora
        ]);

        // Redirecciona a portal.php
        header('Location: portal.php');
        exit;
    }
}

include 'inicial.php';
?>

<main>
    <div class="card card-wide">
        <h2>Solicitar un Turno Médico</h2>

        <form action="turnos.php" method="POST">
            <div class="contenedor-especialidades">
                <div class="form-group columna-item">
                    <label>Clínica Médica:</label>
                    <select class="select-especialidad" onchange="seleccionarMedico(this, 'Clínica Médica')">
                        <option value="">Seleccionar </option>
                        <option value="Dr. Martínez">Dr. Martínez</option>
                            <option value="Dra. Rodríguez">Dra. Rodríguez</option>
                            <option value="Dr. González">Dr. González</option>
                            <option value="Dra. Fernández">Dra. Fernández</option>
                            <option value="Dr. López">Dr. López</option>
                            <option value="Dra. Gómez">Dra. Gómez</option>
                            <option value="Dr. Sánchez">Dr. Sánchez</option>
                            <option value="Dra. Romero">Dra. Romero</option>
                            <option value="Dr. Torres">Dr. Torres</option>
                            <option value="Dra. Díaz">Dra. Díaz</option>
                            <option value="Dr. Castro">Dr. Castro</option>
                            
                    </select>
                </div>

                <div class="form-group columna-item">
                    <label>Pediatría:</label>
                    <select class="select-especialidad" onchange="seleccionarMedico(this, 'Pediatría')">
                        <option value="">Seleccionar</option>
                        <option value="Dr. Quiroga">Dr. Quiroga</option>
                            <option value="Dra. Sosa">Dra. Sosa</option>
                            <option value="Dr. Maldonado">Dr. Maldonado</option>
                            <option value="Dra. Correa">Dra. Correa</option>
                            <option value="Dr. Campos">Dr. Campos</option>
                            <option value="Dra. Vázquez">Dra. Vázquez</option>
                            <option value="Dr. Arias">Dr. Arias</option>
                            <option value="Dra. Ponce">Dra. Ponce</option>
                            <option value="Dr. Luna">Dr. Luna</option>
                            <option value="Dra. Bravo">Dra. Bravo</option>
                    </select>
                </div>

                <div class="form-group columna-item">
                    <label>Cardiología:</label>
                    <select class="select-especialidad" onchange="seleccionarMedico(this, 'Cardiología')">
                        <option value="">Seleccionar </option>
                       <option value="Dr. Ramírez">Dr. Ramírez</option>
                        <option value="Dra. Acosta">Dra. Acosta</option>
                        <option value="Dr. Herrera">Dr. Herrera</option>
                        <option value="Dra. Medina">Dra. Medina</option>
                        <option value="Dr. Silva">Dr. Silva</option>
                        <option value="Dra. Navarro">Dra. Navarro</option>
                        <option value="Dr. Molina">Dr. Molina</option>
                        <option value="Dra. Cabrera">Dra. Cabrera</option>
                        <option value="Dr. Vega">Dr. Vega</option>
                        <option value="Dra. Rojas">Dra. Rojas</option>
                    </select>
                </div>

                <div class="form-group columna-item">
                    <label>Dermatología:</label>
                    <select class="select-especialidad" onchange="seleccionarMedico(this, 'Dermatología')">
                        <option value="">Seleccionar</option>
                        <option value="Dr. Álvarez">Dr. Álvarez</option>
                        <option value="Dra. Suárez">Dra. Suárez</option>
                        <option value="Dr. Giménez">Dr. Giménez</option>
                        <option value="Dra. Pereyra">Dra. Pereyra</option>
                        <option value="Dr. Ortiz">Dr. Ortiz</option>
                        <option value="Dra. Núñez">Dra. Núñez</option>
                        <option value="Dr. Benítez">Dr. Benítez</option>
                        <option value="Dra. Ibarra">Dra. Ibarra</option>
                        <option value="Dr. Figueroa">Dr. Figueroa</option>
                        <option value="Dra. Domínguez">Dra. Domínguez</option>
                    </select>
                </div>
            </div>

            <input type="hidden" id="medico" name="medico" required>
            <input type="hidden" id="especialidad" name="especialidad" required>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha">Fecha del Turno:</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="form-group">
                    <label for="hora">Horario Disponible:</label>
                    <select id="hora" name="hora" required>
                        <option value="">-- Seleccione un horario --</option>
                        <option value="08:00 AM">08:00 AM</option>
                        <option value="09:00 AM">09:00 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="12:00 AM">12:00 AM</option>
                        <option value="14:00 PM">14:00 PM</option>
                        <option value="15:00 PM">15:00 PM</option>
                        <option value="16:00 PM">16:00 PM</option>
                        <option value="17:00 PM">17:00 PM</option>
                        <option value="18:00 PM">18:00 PM</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn">Confirmar Turno</button>
        </form>
    </div>
</main>

<script>
function seleccionarMedico(selectActual, especialidadNombre) {
    const todosLosSelects = document.querySelectorAll('.select-especialidad');
    
    if (selectActual.value !== '') {
        todosLosSelects.forEach(s => {
            if (s !== selectActual) {
                s.value = '';
            }
        });
        
        document.getElementById('medico').value = selectActual.value;
        document.getElementById('especialidad').value = especialidadNombre;
    } else {
        document.getElementById('medico').value = '';
        document.getElementById('especialidad').value = '';
    }
}
</script>

<?php include 'footer.php'; ?>