<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Sistema RFID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 0%, #1e293b 0, transparent 50%), radial-gradient(at 100% 100%, #0f172a 0, transparent 50%);
            color: #e2e8f0;
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
<body class="h-screen flex items-center justify-center">
    <div class="glass-card p-10 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">
                <i class="fa-solid fa-shield-halved text-emerald-400 mr-2"></i> Seguridad
            </h1>
            <p class="text-slate-400 text-sm">Por tu seguridad, debes cambiar la contraseña por defecto antes de continuar.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/30 border border-red-800 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm text-center">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-400 mb-2">Nueva Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-500"></i>
                    </div>
                    <input type="password" name="password" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl pl-11 pr-4 py-3 focus:border-emerald-500 outline-none transition" placeholder="Mínimo 6 caracteres" required>
                </div>
            </div>
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-400 mb-2">Confirmar Nueva Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-500"></i>
                    </div>
                    <input type="password" name="password_confirmation" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl pl-11 pr-4 py-3 focus:border-emerald-500 outline-none transition" placeholder="Repite la contraseña" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-emerald-900/50 flex justify-center items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Contraseña
            </button>
        </form>
    </div>
</body>
</html>