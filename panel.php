<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit(); }

// Consultas rápidas para los contadores
$total_alumnos = $conn->query("SELECT COUNT(*) as t FROM estudiantes")->fetch_assoc()['t'] ?? 0;
$total_notas = $conn->query("SELECT COUNT(*) as t FROM notas")->fetch_assoc()['t'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master2000 | Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        /* Si no tienes estas clases en tu style.css, aquí te aseguro el diseño base */
        .card {
            background: white;
            padding: 2rem;
            border-radius: 2rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: block;
            text-decoration: none;
        }
    </style>
</head>
<body class="pb-12">

    <nav class="bg-white border-b h-20 flex items-center px-8 justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black">M</div>
            <span class="text-xl font-extrabold text-slate-800 tracking-tight">STEVEN ACADEMY</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Administrador</p>
                <p class="text-sm font-bold text-slate-700 leading-none"><?= $_SESSION['user'] ?></p>
            </div>
            <a href="logout.php" class="w-10 h-10 flex items-center justify-center text-red-500 hover:bg-red-50 rounded-xl transition-all">
                <i data-lucide="log-out" class="w-5 h-5"></i>
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-8">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Panel de Gestión</h1>
            <p class="text-slate-500 mt-2 flex items-center gap-2">
                <i data-lucide="graduation-cap" class="w-4 h-4 text-emerald-600"></i>
                Academia: <span class="font-bold text-slate-800">steven_academy</span>
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <a href="estudiantes.php" class="card hover:shadow-xl hover:-translate-y-1 transition-all group border-b-4 border-emerald-500">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Estudiantes</h3>
                <p class="text-slate-400 text-sm mt-1">Matriculados: <span class="font-bold text-slate-600"><?= $total_alumnos ?></span></p>
            </a>

            <a href="notas.php" class="card hover:shadow-xl hover:-translate-y-1 transition-all group border-b-4 border-blue-500">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i data-lucide="edit-3" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Notas</h3>
                <p class="text-slate-400 text-sm mt-1">Registros: <span class="font-bold text-slate-600"><?= $total_notas ?></span></p>
            </a>

            <a href="estadisticas.php" class="card hover:shadow-xl hover:-translate-y-1 transition-all group border-b-4 border-amber-500">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <i data-lucide="bar-chart-2" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Estadísticas</h3>
                <p class="text-slate-400 text-sm mt-1">Análisis de promedios.</p>
            </a>

            <a href="riesgos.php" class="card hover:shadow-xl hover:-translate-y-1 transition-all group border-b-4 border-violet-500">
                <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-violet-600 group-hover:text-white transition-all">
                    <i data-lucide="shield-check" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Riesgos IT</h3>
                <p class="text-slate-400 text-sm mt-1">Seguridad del sistema.</p>
            </a>

        </div>

        <div class="mt-12 p-8 bg-slate-900 rounded-[3rem] text-white flex items-center justify-between overflow-hidden relative">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold">Consola de Seguridad</h2>
                <p class="text-slate-400 text-sm">Monitorea la matriz de riesgos en tiempo real.</p>
                <a href="riesgos.php" class="mt-4 inline-flex items-center gap-2 bg-white text-slate-900 px-6 py-2 rounded-xl font-bold text-sm hover:bg-violet-400 transition-colors">
                    Abrir Matriz <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
            </div>
            <i data-lucide="shield-alert" class="w-32 h-32 text-white/5 absolute -right-4 -bottom-4"></i>
        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>