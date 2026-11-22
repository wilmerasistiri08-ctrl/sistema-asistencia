@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Formulario de Registro -->
    <div class="lg:col-span-1">
        <div class="glass-card p-8 sticky top-6">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-500"></i> Nuevo Usuario
            </h2>
            <form action="{{ route('admin.usuario.crear') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-400 mb-2">UID Tarjeta RFID</label>
                    <!-- Aquí quité el placeholder -->
                    <input type="text" name="uid" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl px-4 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition" required>
                </div>
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-400 mb-2">Nombre Completo</label>
                    <!-- Aquí quité el placeholder -->
                    <input type="text" name="nombre" class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl px-4 py-3 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition" required>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-emerald-900/50 flex justify-center items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Usuario
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="lg:col-span-2">
        <div class="glass-card overflow-hidden">
            
            <!-- Encabezado con Título y Buscador -->
            <div class="p-6 border-b border-slate-700/50 bg-slate-800/30">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                    <h2 class="text-xl font-bold text-white">Usuarios en el Sistema</h2>
                    <span class="bg-emerald-900/50 text-emerald-400 text-sm font-bold px-4 py-1.5 rounded-full border border-emerald-800">{{ count($usuarios) }} Total</span>
                </div>
                
                <!-- BARRA DE BÚSQUEDA -->
                <form method="GET" action="{{ route('admin.usuarios') }}" class="flex w-full gap-2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-slate-500"></i>
                        </div>
                        <input type="text" name="buscar" value="{{ $buscar ?? '' }}" 
                               class="w-full bg-slate-900 text-white border border-slate-700 rounded-xl pl-10 pr-4 py-2 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition text-sm" 
                               placeholder="Buscar por nombre o UID...">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2 rounded-xl transition text-sm font-semibold">
                        Buscar
                    </button>
                    @if(isset($buscar) && $buscar != '')
                        <a href="{{ route('admin.usuarios') }}" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-xl transition flex items-center justify-center" title="Limpiar búsqueda">
                            <i class="fa-solid fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>

            <table class="w-full text-left text-sm">
                <thead class="bg-slate-800/50 text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-4 px-6 font-semibold">UID</th>
                        <th class="py-4 px-6 font-semibold">Nombre</th>
                        <th class="py-4 px-6 font-semibold">Estado</th>
                        <th class="py-4 px-6 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50 bg-slate-800/20">
                    @forelse($usuarios as $user)
                    <tr class="hover:bg-slate-800/60 transition">
                        <td class="py-4 px-6 font-mono text-emerald-400 font-bold">{{ $user->uid }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-200">{{ $user->nombre }}</td>
                        <td class="py-4 px-6">
                            @if($user->activo) 
                                <span class="bg-green-900/50 text-green-400 border border-green-800 px-3 py-1 rounded-lg text-xs font-bold">Activo</span> 
                            @else 
                                <span class="bg-red-900/50 text-red-400 border border-red-800 px-3 py-1 rounded-lg text-xs font-bold">Inactivo</span> 
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right flex justify-end gap-2">
                            <a href="{{ route('admin.usuario.asistencias', $user->id) }}" class="text-xs bg-slate-800 border border-slate-600 hover:bg-slate-700 px-3 py-2 rounded-lg transition text-slate-300 shadow-sm flex items-center gap-1.5 font-semibold">
                                <i class="fa-solid fa-table-cells text-emerald-500"></i> Ver Asistencia
                            </a>
                            <form action="{{ route('admin.usuario.toggle', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs px-3 py-2 rounded-lg border font-semibold {{ $user->activo ? 'border-red-900/50 text-red-400 hover:bg-red-900/30' : 'border-green-900/50 text-green-400 hover:bg-green-900/30' }} transition shadow-sm">
                                    {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-400">
                            <i class="fa-solid fa-magnifying-glass mb-2 text-2xl opacity-50"></i>
                            <p>No se encontraron usuarios con ese nombre o UID.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection