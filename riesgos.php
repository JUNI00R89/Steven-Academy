<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Lógica de cálculo dinámico
$resultado = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $riesgo_nombre = $_POST['riesgo_nombre'] ?? 'Riesgo sin nombre';
    $probabilidad = intval($_POST['probabilidad']);
    $impacto = intval($_POST['impacto']);
    $nivel = $probabilidad * $impacto;

    // Generador de justificaciones técnicas automáticas
    if ($nivel >= 6) {
        $color_clase = "bg-red-600";
        $shadow = "shadow-red-200";
        $etiqueta = "CRÍTICO / ALTO";
        $justificacion = "Se requiere implementación inmediata de medidas de mitigación. El fallo en este punto compromete la integridad del sistema Master2000 y la disponibilidad de los datos académicos.";
    } elseif ($nivel >= 3) {
        $color_clase = "bg-orange-500";
        $shadow = "shadow-orange-200";
        $etiqueta = "MODERADO / MEDIO";
        $justificacion = "Riesgo significativo. Se recomienda programar un parche de seguridad o actualización de infraestructura en el próximo sprint de desarrollo.";
    } else {
        $color_clase = "bg-emerald-500";
        $shadow = "shadow-emerald-200";
        $etiqueta = "CONTROLADO / BAJO";
        $justificacion = "El impacto es mínimo o la probabilidad es muy baja. Se sugiere mantener monitoreo en los logs del servidor sin requerir cambios estructurales inmediatos.";
    }

    $resultado = [
        'nombre' => $riesgo_nombre,
        'nivel' => $nivel,
        'etiqueta' => $etiqueta,
        'clase' => $color_clase,
        'shadow' => $shadow,
        'justificacion' => $justificacion
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master2000 | Calculadora de Riesgos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-card { background: white; border-radius: 2.5rem; border: 1px solid #f1f5f9; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="min-h-screen pb-12">

    <nav class="bg-white border-b border-gray-100 mb-8">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <i data-lucide="cpu" class="w-6 h-6"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-900">Calculadora Dinámica de Riesgos</h1>
            </div>
            <a href="panel.php" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-slate-800 transition-all">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Volver
            </a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="glass-card p-8">
                <h2 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                    <i data-lucide="settings-2" class="text-indigo-500"></i> Parámetros
                </h2>
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-400 mb-2">Nombre del Riesgo</label>
                        <input type="text" name="riesgo_nombre" placeholder="Ej: Inyección SQL" required
                               class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:outline-none focus:border-indigo-500 transition-all font-bold">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2">Probabilidad</label>
                            <select name="probabilidad" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl font-bold appearance-none">
                                <option value="1">Baja (1)</option>
                                <option value="2">Media (2)</option>
                                <option value="3">Alta (3)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2">Impacto</label>
                            <select name="impacto" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl font-bold appearance-none">
                                <option value="1">Bajo (1)</option>
                                <option value="2">Medio (2)</option>
                                <option value="3">Alto (3)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white p-5 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="play" class="w-5 h-5"></i> CALCULAR NIVEL
                    </button>
                </form>
            </div>

            <div class="flex flex-col justify-center">
                <?php if ($resultado): ?>
                <div class="glass-card p-8 border-t-8 border-indigo-500 animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Análisis de:</span>
                    <h3 class="text-2xl font-black text-slate-800 mb-6"><?= htmlspecialchars($resultado['nombre']) ?></h3>
                    
                    <div class="flex items-center gap-6 mb-8">
                        <div class="w-20 h-20 <?= $resultado['clase'] ?> <?= $resultado['shadow'] ?> text-white rounded-[2rem] flex items-center justify-center text-4xl font-black shadow-2xl">
                            <?= $resultado['nivel'] ?>
                        </div>
                        <div>
                            <span class="block text-sm font-black <?= str_replace('bg-', 'text-', $resultado['clase']) ?> uppercase"><?= $resultado['etiqueta'] ?></span>
                            <p class="text-slate-400 text-xs font-bold italic italic">Nivel calculado (P × I)</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h4 class="text-xs font-black text-slate-400 uppercase mb-3 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Justificación Técnica
                        </h4>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            <?= $resultado['justificacion'] ?>
                        </p>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center p-10 opacity-40">
                    <i data-lucide="calculator" class="w-16 h-16 mx-auto mb-4 text-slate-300"></i>
                    <p class="font-bold text-slate-400">Ingresa los datos para generar el análisis técnico</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>