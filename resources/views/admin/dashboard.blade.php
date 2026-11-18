@extends('layouts.app')

@section('title', 'Resumen General')

@section('content')
<!-- Tarjetas de Resumen -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="glass-card p-6 flex items-center gap-6 hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center text-emerald-400 text-2xl shadow-inner border border-slate-700">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-slate-400 text-sm font-semibold uppercase tracking-wide">Total Usuarios</p>
            <h3 class="text-4xl font-bold text-white mt-1">{{ $totalUsuarios }}</h3>
        </div>
    </div>
    <div class="glass-card p-6 flex items-center gap-6 hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center text-teal-400 text-2xl shadow-inner border border-slate-700">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <p class="text-slate-400 text-sm font-semibold uppercase tracking-wide">Asistencias</p>
            <h3 class="text-4xl font-bold text-white mt-1">{{ $totalRegistros }}</h3>
        </div>
    </div>
</div>

<!-- Tabla de Últimos Movimientos -->
<div class="glass-card overflow-hidden">
    <div class="p-6 border-b border-slate-700/50">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-bolt text-emerald-500"></i> Últimos Movimientos
        </h3>
    </div>
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-800/50 text-slate-400 border-b border-slate-700">
            <tr>
                <th class="py-4 px-6 font-semibold">UID Tarjeta</th>
                <th class="py-4 px-6 font-semibold">Tipo</th>
                <th class="py-4 px-6 font-semibold">Fecha y Hora</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-700/50 bg-slate-800/20">
            @forelse($ultimosRegistros as $reg)
            <tr class="hover:bg-slate-800/60 transition">
                <td class="py-4 px-6 text-emerald-400 font-mono font-bold">{{ $reg->uid }}</td>
                <td class="py-4 px-6">
                    @if($reg->tipo == 'ENTRADA')
                        <span class="bg-blue-900/50 text-blue-400 px-3 py-1 rounded-lg text-xs font-bold border border-blue-800"><i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> ENTRADA</span>
                    @else
                        <span class="bg-orange-900/50 text-orange-400 px-3 py-1 rounded-lg text-xs font-bold border border-orange-800"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> SALIDA</span>
                    @endif
                </td>
                <td class="py-4 px-6 text-slate-400 font-medium">{{ $reg->fecha_hora }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="py-10 text-center text-slate-500 font-medium">No hay movimientos recientes.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection