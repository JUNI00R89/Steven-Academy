<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit(); }

$mensaje = "";
if(isset($_POST['guardar'])){
    $e = trim($_POST['estudiante']);
    $m = $_POST['materia'];
    $n = floatval($_POST['nota']);
    if(!empty($e) && !empty($m) && $n >= 0 && $n <= 5){
        $stmt = $conn->prepare("INSERT INTO notas (estudiante, materia, nota) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $e, $m, $n);
        if($stmt->execute()) $mensaje = "<div class='alert alert-success'>✅ Nota guardada</div>";
        else $mensaje = "<div class='alert alert-error'>❌ Error en SQL</div>";
        $stmt->close();
    }
}

function getClase($n) {
    if($n >= 4.0) return 'grade-excellent';
    if($n >= 3.0) return 'grade-regular';
    return 'grade-bad';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas | Master2000</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="topbar">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white"><i data-lucide="edit-3"></i></div>
                <h1 class="text-3xl font-bold text-slate-800">Calificaciones</h1>
            </div>
            <a href="panel.php" class="btn bg-slate-800"><i data-lucide="arrow-left"></i> Volver</a>
        </div>
        <?= $mensaje ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="card h-fit">
                <form method="POST" class="space-y-4">
                    <div class="form-group"><label>Nombre del Estudiante</label><input type="text" name="estudiante" required></div>
                    <div class="form-group"><label>Materia</label>
                        <select name="materia" required>
                            <option value="Programación">Programación</option>
                            <option value="Bases de Datos">Bases de Datos</option>
                            <option value="Matemáticas">Matemáticas</option>
                            <option value="Inglés">Inglés</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Nota (0-5)</label><input type="number" step="0.1" name="nota" min="0" max="5" required></div>
                    <button name="guardar" class="btn w-full">Registrar Nota</button>
                </form>
            </div>
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $r = $conn->query("SELECT * FROM notas ORDER BY id DESC LIMIT 10");
                while($row = $r->fetch_assoc()): ?>
                <div class="note-card flex justify-between items-center shadow-sm">
                    <div>
                        <div class="font-bold text-slate-800"><?= htmlspecialchars($row['estudiante']) ?></div>
                        <div class="text-xs text-slate-400 uppercase font-black tracking-widest"><?= htmlspecialchars($row['materia']) ?></div>
                    </div>
                    <div class="note-grade <?= getClase($row['nota']) ?>"><?= number_format($row['nota'],1) ?></div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>