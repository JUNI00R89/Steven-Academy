<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEVEN ACADEMY | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-emerald-900 to-teal-900 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto p-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-10 text-center">
                <div class="w-20 h-20 mx-auto bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-4xl font-bold mb-6">M</div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2 uppercase">Steven Academy</h1>
                <p class="text-gray-500 tracking-widest uppercase text-xs font-black">Sistema de Gestión Académica</p>
            </div>

            <form action="login.php" method="POST" class="px-10 pb-10 space-y-6">
                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" name="usuario" placeholder="Admin" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="clave" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn w-full py-4 text-lg">
                    Ingresar
                    <i data-lucide="arrow-right"></i>
                </button>
            </form>
        </div>
        <p class="text-center text-white/50 mt-6 text-sm italic">© 2026 Master2000 Pro</p>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>