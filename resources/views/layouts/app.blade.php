<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencia RFID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            /* Fondo oscuro difuminado */
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 0%, #1e293b 0, transparent 50%), radial-gradient(at 100% 100%, #0f172a 0, transparent 50%);
            color: #e2e8f0;
        }
        .glass-panel { 
            background: rgba(30, 41, 59, 0.6); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05); 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3); 
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.8); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            border-radius: 1.25rem; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }
        .nav-link { transition: all 0.3s ease; border-radius: 1rem; margin: 0.5rem 1rem; }
        .nav-link:hover { background: rgba(255, 255, 255, 0.05); color: #10b981; transform: translateX(4px); }
        .nav-link.active { background: rgba(16, 185, 129, 0.1); color: #10b981; font-weight: 600; border-right: 3px solid #10b981; }
    </style>
</head>
<body class="h-screen flex overflow-hidden">

    <!-- Sidebar Flotante -->
    <aside class="w-72 m-4 rounded-3xl glass-panel flex flex-col hidden md:flex z-10">
        <div class="h-20 flex items-center px-8">
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-teal-300 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-900/50 flex items-center justify-center text-emerald-400">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                RFID System
            </h1>
        </div>
        <nav class="flex-1 py-4 overflow-y-auto">
            <p class="px-8 text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Menú</p>
            <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-400' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-lg"></i> Dashboard
            </a>
            <a href="{{ route('admin.usuarios') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 {{ request()->routeIs('admin.usuarios') || request()->routeIs('admin.usuario.asistencias') ? 'active' : 'text-slate-400' }}">
                <i class="fa-solid fa-users w-5 text-center text-lg"></i> Usuarios
            </a>
        </nav>
        <div class="p-6 m-4 rounded-2xl bg-slate-800/50 border border-slate-700 text-center">
            <p class="text-xs text-slate-400 font-medium">Sistema de Asistencia &copy; 2026</p>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Topbar -->
        <header class="h-20 flex items-center justify-between px-10 z-10">
            <h2 class="text-2xl font-bold text-white">@yield('title', 'Panel de Control')</h2>
            
            <!-- AQUÍ ESTÁ EL CAMBIO: Mostrar nombre de usuario y botón Salir -->
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-slate-300">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-900/50 hover:bg-red-800 text-red-400 border border-red-800 px-4 py-2 rounded-full text-sm font-semibold transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>
            <!-- FIN DEL CAMBIO -->

        </header>

        <!-- Contenido Dinámico -->
        <div class="flex-1 overflow-y-auto px-10 pb-10">
            @if(session('success'))
                <div class="bg-emerald-900/30 backdrop-blur-md border border-emerald-800 text-emerald-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-emerald-900/50 flex items-center justify-center"><i class="fa-solid fa-check text-emerald-500"></i></div> 
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-900/30 backdrop-blur-md border border-red-800 text-red-400 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                    <ul class="list-disc list-inside font-medium"><li>{{ $errors->first() }}</li></ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>