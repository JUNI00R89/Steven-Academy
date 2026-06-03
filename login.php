<?php
session_start();
include("conexion.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $u = trim($_POST['usuario']);
    $c = trim($_POST['clave']);

    if(!empty($u) && !empty($c)){
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND clave = ?");
        $stmt->bind_param("ss", $u, $c);
        $stmt->execute();
        $r = $stmt->get_result();

        if($r->num_rows > 0){
            $_SESSION['user'] = $u;
            header("Location: panel.php");
            exit();
        } else {
            $error = "Acceso denegado. Verifique sus datos.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error de Acceso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="card max-w-sm w-full text-center">
        <h2 class="text-2xl font-bold text-red-600 mb-4">Error</h2>
        <p class="text-gray-600 mb-6"><?= isset($error) ? $error : 'Algo salió mal' ?></p>
        <a href="index.php" class="btn w-full">Reintentar</a>
    </div>
</body>
</html>