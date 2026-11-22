<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema RFID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 0%, #1e293b 0, transparent 50%), radial-gradient(at 100% 100%, #0f172a 0, transparent 50%);
        }
        .glass-card { 
            background: rgba(30, 41, 59, 0.8); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            border-radius: 1.25rem; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center text-slate-200">
    <div class="glass-card p-10 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-teal-300 flex items-center justify-center gap-3 mb-2">
                <i class="fa-solid fa-leaf text-emerald-400"></i> RFID System
            </h1>
            <p class="text-slate-400">Ingresa tus credenciales de administrador</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/30 border border-red-800 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-400 mb-2">Correo Electrónico</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-slate-500"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl pl-11 pr-4 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition" placeholder="admin@admin.com" required autofocus>
                </div>
            </div>

            <!-- CAMPO CONTRASEÑA CON OJITO -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-400 mb-2">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-500"></i>
                    </div>
                    <input type="password" name="password" id="password" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl pl-11 pr-12 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition" placeholder="••••••••" required>
                    
                    <!-- Botón ojito -->
                    <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-emerald-400 transition"
                            title="Mostrar/Ocultar contraseña">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-emerald-900/50 flex justify-center items-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
            </button>
        </form>
    </div>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>