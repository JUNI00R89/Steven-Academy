<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// ==================== ESTADÍSTICAS GENERALES ====================

// Totales
$totalEstudiantes = $conn->query("SELECT COUNT(*) as total FROM estudiantes")->fetch_assoc()['total'];
$totalNotas = $conn->query("SELECT COUNT(*) as total FROM notas")->fetch_assoc()['total'];
$totalProfesores = $conn->query("SELECT COUNT(*) as total FROM profesores")->fetch_assoc()['total'] ?? 0;

// Promedios
$promedioGeneral = $conn->query("SELECT AVG(nota) as avg FROM notas")->fetch_assoc()['avg'] ?? 0;
$mejorNota = $conn->query("SELECT MAX(nota) as max FROM notas")->fetch_assoc()['max'] ?? 0;
$peorNota = $conn->query("SELECT MIN(nota) as min FROM notas")->fetch_assoc()['min'] ?? 0;

// Aprobados y Reprobados
$aprobados = $conn->query("SELECT COUNT(*) as cant FROM notas WHERE nota >= 3.0")->fetch_assoc()['cant'];
$reprobados = $totalNotas - $aprobados;

// Mejores estudiantes
$mejoresEstudiantes = $conn->query("
    SELECT estudiante, AVG(nota) as promedio, COUNT(*) as materias 
    FROM notas 
    GROUP BY estudiante 
    ORDER BY promedio DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master2000 - Estadísticas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <div class="topbar">
        <div class="logo">
            <span class="text-4xl">🌌</span>
            <span>Master2000</span>
        </div>
        <a href="panel.php" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Volver al Panel
        </a>
    </div>

    <h1 class="text-4xl font-bold text-white mb-2">📊 Panel de Estadísticas</h1>
    <p class="text-slate-400 mb-10">Análisis académico en tiempo real</p>

    <!-- KPIs -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="card p-6 text-center">
            <div class="text-4xl mb-3">👨‍🎓</div>
            <p class="text-4xl font-bold text-white"><?= $totalEstudiantes ?></p>
            <p class="text-slate-400 text-sm">Estudiantes</p>
        </div>
        <div class="card p-6 text-center">
            <div class="text-4xl mb-3">📝</div>
            <p class="text-4xl font-bold text-violet-400"><?= $totalNotas ?></p>
            <p class="text-slate-400 text-sm">Calificaciones</p>
        </div>
        <div class="card p-6 text-center">
            <div class="text-4xl mb-3">👨‍🏫</div>
            <p class="text-4xl font-bold text-emerald-400"><?= $totalProfesores ?></p>
            <p class="text-slate-400 text-sm">Profesores</p>
        </div>
        <div class="card p-6 text-center">
            <div class="text-4xl mb-3">📈</div>
            <p class="text-4xl font-bold <?= $promedioGeneral >= 3.5 ? 'text-emerald-400' : 'text-amber-400' ?>">
                <?= number_format($promedioGeneral, 2) ?>
            </p>
            <p class="text-slate-400 text-sm">Promedio General</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Gráfico de Distribución -->
        <div class="card p-8">
            <h3 class="text-xl font-semibold mb-6">Distribución de Notas</h3>
            <canvas id="distribucionChart" height="120"></canvas>
        </div>

        <!-- Mejores Estudiantes -->
        <div class="card p-8">
            <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                <i data-lucide="trophy"></i> Top 5 Estudiantes
            </h3>
            <div class="space-y-4">
                <?php 
                $pos = 1;
                while($row = $mejoresEstudiantes->fetch_assoc()): 
                ?>
                    <div class="flex items-center justify-between bg-white/5 p-4 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl font-bold text-violet-400 w-8"><?= $pos++ ?></span>
                            <div>
                                <p class="font-medium"><?= htmlspecialchars($row['estudiante']) ?></p>
                                <p class="text-xs text-slate-400"><?= $row['materias'] ?> materias</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-emerald-400"><?= number_format($row['promedio'], 2) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Estado General -->
        <div class="lg:col-span-2 card p-8">
            <h3 class="text-xl font-semibold mb-6">Estado Académico General</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-8 bg-emerald-500/10 rounded-3xl border border-emerald-500/30">
                    <p class="text-5xl font-bold text-emerald-400"><?= $aprobados ?></p>
                    <p class="text-emerald-400 mt-2">Aprobados</p>
                </div>
                <div class="text-center p-8 bg-red-500/10 rounded-3xl border border-red-500/30">
                    <p class="text-5xl font-bold text-red-400"><?= $reprobados ?></p>
                    <p class="text-red-400 mt-2">Reprobados</p>
                </div>
                <div class="text-center p-8 bg-violet-500/10 rounded-3xl border border-violet-500/30">
                    <p class="text-5xl font-bold text-violet-400"><?= $totalNotas > 0 ? round(($aprobados / $totalNotas) * 100) : 0 ?>%</p>
                    <p class="text-violet-400 mt-2">Tasa de Aprobación</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // Gráfico de Distribución
    new Chart(document.getElementById('distribucionChart'), {
        type: 'bar',
        data: {
            labels: ['Excelente (4.5-5.0)', 'Bueno (3.5-4.4)', 'Regular (3.0-3.4)', 'Insuficiente (<3.0)'],
            datasets: [{
                label: 'Cantidad de Notas',
                data: [
                    <?= $conn->query("SELECT COUNT(*) FROM notas WHERE nota >= 4.5")->fetch_assoc()['COUNT(*)'] ?>,
                    <?= $conn->query("SELECT COUNT(*) FROM notas WHERE nota >= 3.5 AND nota < 4.5")->fetch_assoc()['COUNT(*)'] ?>,
                    <?= $conn->query("SELECT COUNT(*) FROM notas WHERE nota >= 3.0 AND nota < 3.5")->fetch_assoc()['COUNT(*)'] ?>,
                    <?= $reprobados ?>
                ],
                backgroundColor: ['#22c55e', '#3b82f6', '#eab308', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
</body>
</html>