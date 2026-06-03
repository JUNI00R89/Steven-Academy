<?php
include("conexion.php");
session_start();

// Seguridad: Si no hay sesión, redirigir al login
if(!isset($_SESSION['user'])){ 
    header("Location: index.php"); 
    exit(); 
}

// 1. OBTENER MÉTRICAS GENERALES
// Nota: Se usa la tabla 'estudiantes' para el conteo total
$total_estudiantes = $conn->query("SELECT COUNT(*) as total FROM estudiantes")->fetch_assoc()['total'];
$total_notas = $conn->query("SELECT COUNT(*) as total FROM notas")->fetch_assoc()['total'];
$promedio_res = $conn->query("SELECT AVG(nota) as promedio FROM notas")->fetch_assoc()['promedio'];
$promedio_general = $promedio_res ? number_format($promedio_res, 2) : "0.0";

// 2. DATOS PARA EL GRÁFICO (Promedio por Materia)
$materias_labels = [];
$materias_valores = [];
$query_grafico = $conn->query("SELECT materia, AVG(nota) as promedio FROM notas GROUP BY materia");
while($row = $query_grafico->fetch_assoc()){
    $materias_labels[] = $row['materia'];
    $materias_valores[] = round($row['promedio'], 2);
}

// 3. TOP 5 ESTUDIANTES (Variable unificada: top_estudiantes)
$query = "SELECT estudiante, AVG(nota) as promedio 
          FROM notas 
          GROUP BY estudiante 
          ORDER BY promedio DESC 
          LIMIT 5";

$top_estudiantes = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master2000 | Estadísticas Académicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="min-h-screen pb-12">

    <nav class="bg-white border-b border-gray-100 mb-8">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <i data-lucide="bar-chart-big" class="w-6 h-6"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Análisis de Rendimiento</h1>
            </div>
            <a href="panel.php" class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-all font-bold shadow-sm">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Volver al Panel
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Estudiantes</p>
                    <h3 class="text-3xl font-black text-slate-800"><?= $total_estudiantes ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="clipboard-list" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Calificaciones</p>
                    <h3 class="text-3xl font-black text-slate-800"><?= $total_notas ?></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="star" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Promedio Gral.</p>
                    <h3 class="text-3xl font-black text-slate-800"><?= $promedio_general ?></h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="bar-chart-3" class="text-emerald-500"></i>
                        Promedio por Asignatura
                    </h3>
                </div>
                <div class="h-[350px]">
                    <canvas id="graficoMaterias"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <h3 class="text-xl font-bold text-slate-800 mb-8 flex items-center gap-2">
                    <i data-lucide="trophy" class="text-amber-500"></i>
                    Mejores Promedios
                </h3>
                <div class="space-y-4">
                    <?php 
                    $count = 1;
                    if($top_estudiantes && $top_estudiantes->num_rows > 0):
                        while($est = $top_estudiantes->fetch_assoc()): 
                            $color = ($count == 1) ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-500';
                    ?>
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-emerald-200 transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 flex items-center justify-center font-black text-sm <?= $color ?> rounded-xl">
                                #<?= $count++ ?>
                            </span>
                            <span class="font-bold text-slate-700"><?= htmlspecialchars($est['estudiante']) ?></span>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-emerald-600"><?= number_format($est['promedio'], 1) ?></span>
                        </div>
                    </div>
                    <?php 
                        endwhile; 
                    else: ?>
                        <p class="text-center text-slate-400 py-10">No hay datos suficientes.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const ctx = document.getElementById('graficoMaterias').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($materias_labels) ?>,
                datasets: [{
                    label: 'Nota Promedio',
                    data: <?= json_encode($materias_valores) ?>,
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    borderColor: '#10b981',
                    borderWidth: 3,
                    borderRadius: 12,
                    hoverBackgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        max: 5,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: { font: { weight: 'bold' } }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' } }
                    }
                }
            }
        });
    </script>
</body>
</html>