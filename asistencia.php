<?php
include("conexion.php");
session_start();
if(!isset($_SESSION['user'])) header("Location: index.php");

if(isset($_POST['guardar_asistencia'])){
    $estudiante = $_POST['estudiante'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    
    $stmt = $conn->prepare("INSERT INTO asistencia (estudiante, fecha, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $estudiante, $fecha, $estado);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEVEN ACADEMY - Asistencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container">
    <div class="topbar">
        <div class="logo">
            <span class="text-4xl">🌌</span>
            <span>Master2000</span>
        </div>
        <a href="panel.php" class="btn btn-secondary">← Panel</a>
    </div>

    <div class="card p-8">
        <h3 class="text-2xl font-semibold mb-6">Registro de Asistencia</h3>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="form-group">
                <label>Estudiante</label>
                <input type="text" name="estudiante" required>
            </div>
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select name="estado" required>
                    <option value="Presente">Presente</option>
                    <option value="Ausente">Ausente</option>
                    <option value="Tarde">Tarde</option>
                </select>
            </div>
            <button name="guardar_asistencia" class="btn btn-primary md:col-span-3 py-6">Guardar Asistencia</button>
        </form>
    </div>
</div>
<script>lucide.createIcons();</script>
</body>
</html>