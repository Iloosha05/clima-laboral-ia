@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">HR Dashboard</h1>

    <div class="bg-white shadow rounded p-4 mb-6">
        <p class="text-lg">Promedio de estado de ánimo: <strong>{{ number_format($avgMood, 2) }}</strong></p>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-semibold mb-2">Últimos comentarios de empleados</h2>
        @if($entries->isEmpty())
            <p>No hay entradas aún.</p>
        @else
            <ul class="list-disc pl-5">
                @foreach($entries as $entry)
                    <li>
                        <strong>{{ $entry->user->name }}:</strong> {{ $entry->comment ?? 'Sin comentario' }} ({{ $entry->mood }})
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
@endsection
