<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit(); }

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $grado = $_POST['grado'];

    // Preparar la consulta para evitar inyecciones SQL (Riesgo que identificamos antes)
    $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, documento, grado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $documento, $grado);

    if ($stmt->execute()) {
        $mensaje = "success";
    } else {
        $mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Master2000 | Nuevo Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-card { background: white; border-radius: 2.5rem; border: 1px solid #f1f5f9; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full">
        <a href="estudiantes.php" class="flex items-center gap-2 text-slate-400 hover:text-slate-800 font-bold mb-6 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver a la lista
        </a>

        <div class="glass-card p-10">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="user-plus" class="w-8 h-8"></i>
            </div>
            
            <h2 class="text-3xl font-black text-slate-900 mb-2">Nuevo Estudiante</h2>
            <p class="text-slate-500 mb-8 text-sm">Ingresa los datos para matricular al alumno en la academia.</p>

            <?php if($mensaje == "success"): ?>
                <div class="bg-emerald-50 text-emerald-700 p-4 rounded-2xl mb-6 text-sm font-bold flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i> ¡Estudiante registrado con éxito!
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Nombre Completo</label>
                    <input type="text" name="nombre" required placeholder="Ej: Juan Pérez"
                        class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:border-emerald-500 transition-all font-semibold text-slate-700">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Documento de Identidad</label>
                    <input type="text" name="documento" required placeholder="ID único"
                        class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:border-emerald-500 transition-all font-semibold text-slate-700">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Grado / Curso</label>
                    <select name="grado" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:border-emerald-500 font-semibold text-slate-700 appearance-none">
                        <option value="10-A">10-A</option>
                        <option value="10-B">10-B</option>
                        <option value="11-A">11-A</option>
                        <option value="11-B">11-B</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white p-5 rounded-2xl font-black shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i> REGISTRAR MATRÍCULA
                </button>
            </form>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>