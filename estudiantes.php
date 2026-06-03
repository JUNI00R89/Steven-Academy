<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit(); }

// Consultar todos los estudiantes
$resultado = $conn->query("SELECT * FROM estudiantes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Master2000 | Estudiantes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 p-8">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900">Estudiantes</h1>
                <p class="text-slate-500">Gestión de matrícula y datos básicos</p>
            </div>
            <div class="flex gap-4">
                <a href="panel.php" class="p-4 bg-white border border-slate-200 rounded-2xl text-slate-600 hover:bg-slate-50 transition-all">
                    <i data-lucide="layout-dashboard"></i>
                </a>
                <a href="agregar_estudiante.php" class="bg-emerald-600 text-white px-6 py-4 rounded-2xl font-bold flex items-center gap-2 hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">
                    <i data-lucide="user-plus"></i> Nuevo Estudiante
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="p-6 text-left">ID</th>
                        <th class="p-6 text-left">Nombre Completo</th>
                        <th class="p-6 text-left">Documento</th>
                        <th class="p-6 text-center">Grado</th>
                        <th class="p-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while($row = $resultado->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-6 text-sm font-bold text-slate-400">#<?= $row['id'] ?></td>
                        <td class="p-6">
                            <span class="font-bold text-slate-700 block"><?= htmlspecialchars($row['nombre']) ?></span>
                            <span class="text-[10px] text-emerald-600 font-black uppercase">Activo</span>
                        </td>
                        <td class="p-6 text-sm text-slate-500 font-medium"><?= $row['documento'] ?></td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold"><?= $row['grado'] ?></span>
                        </td>
                        <td class="p-6">
                            <div class="flex justify-center gap-2">
                                <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"><i data-lucide="edit" class="w-4 h-4"></i></button>
                                <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>