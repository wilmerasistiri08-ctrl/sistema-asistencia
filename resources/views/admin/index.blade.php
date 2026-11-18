<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Asistencia RFID</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-200 min-h-screen p-6">

    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fa-solid fa-id-card text-indigo-500"></i> Sistema de Asistencia RFID
                </h1>
                <p class="text-slate-400 mt-1">Panel de Administración y Monitoreo</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="bg-indigo-900/50 text-indigo-300 py-1 px-3 rounded-full text-sm border border-indigo-700/50">
                    <i class="fa-solid fa-circle text-green-500 text-xs mr-2 animate-pulse"></i>Sistema en Línea
                </span>
            </div>
        </header>

        <!-- Alertas -->
        @if(session('success'))
            <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6">
                <ul class="mb-0 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Columna Izquierda: Formulario -->
            <div class="lg:col-span-1">
                <div class="glass rounded-2xl p-6 shadow-xl">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-indigo-400"></i> Nuevo Usuario
                    </h2>
                    <form action="{{ route('admin.usuario.crear') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-400 mb-2">UID de la Tarjeta</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-wifi text-slate-500"></i>
                                </div>
                                <input type="text" name="uid" class="w-full bg-slate-800 text-white border border-slate-700 rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" placeholder="Ej: A1B2C3D4" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-400 mb-2">Nombre Completo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-slate-500"></i>
                                </div>
                                <input type="text" name="nombre" class="w-full bg-slate-800 text-white border border-slate-700 rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" placeholder="Ej: Juan Pérez" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-4 rounded-lg transition-all flex justify-center items-center gap-2 shadow-lg shadow-indigo-600/30">
                            <i class="fa-solid fa-save"></i> Registrar Usuario
                        </button>
                    </form>
                </div>
            </div>

            <!-- Columna Derecha: Tabla de Usuarios -->
            <div class="lg:col-span-2">
                <div class="glass rounded-2xl p-6 shadow-xl h-full">
                    <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-users text-indigo-400"></i> Usuarios Autorizados
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-400 text-sm border-b border-slate-700">
                                    <th class="pb-3 font-medium">UID</th>
                                    <th class="pb-3 font-medium">Nombre</th>
                                    <th class="pb-3 font-medium">Estado</th>
                                    <th class="pb-3 font-medium text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($usuarios as $user)
                                <tr class="border-b border-slate-700/50 hover:bg-slate-800/50 transition">
                                    <td class="py-3"><code class="bg-slate-800 px-2 py-1 rounded text-indigo-300">{{ $user->uid }}</code></td>
                                    <td class="py-3 font-medium text-white">{{ $user->nombre }}</td>
                                    <td class="py-3">
                                        @if($user->activo)
                                            <span class="bg-green-900/40 text-green-400 py-1 px-2.5 rounded-full text-xs font-medium border border-green-800/50">Activo</span>
                                        @else
                                            <span class="bg-red-900/40 text-red-400 py-1 px-2.5 rounded-full text-xs font-medium border border-red-800/50">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        <form action="{{ route('admin.usuario.toggle', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs px-3 py-1.5 rounded-md border {{ $user->activo ? 'border-red-500/50 text-red-400 hover:bg-red-500/10' : 'border-green-500/50 text-green-400 hover:bg-green-500/10' }} transition">
                                                {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Registros -->
        <div class="mt-6 glass rounded-2xl p-6 shadow-xl">
            <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-indigo-400"></i> Últimos Registros de Asistencia
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 text-sm border-b border-slate-700">
                            <th class="pb-3 font-medium">UID Tarjeta</th>
                            <th class="pb-3 font-medium">Tipo de Movimiento</th>
                            <th class="pb-3 font-medium">Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($registros as $reg)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-800/50 transition">
                            <td class="py-3"><code class="text-slate-300">{{ $reg->uid }}</code></td>
                            <td class="py-3">
                                @if($reg->tipo == 'ENTRADA')
                                    <span class="bg-blue-900/40 text-blue-400 py-1 px-2.5 rounded-full text-xs font-medium border border-blue-800/50 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i> ENTRADA
                                    </span>
                                @else
                                    <span class="bg-orange-900/40 text-orange-400 py-1 px-2.5 rounded-full text-xs font-medium border border-orange-800/50 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> SALIDA
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-slate-400">{{ $reg->fecha_hora }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-slate-500">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                No hay registros de asistencia aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>