@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Encuesta diaria de estado de ánimo</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('mood.store') }}" class="bg-white shadow rounded p-4">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="mood">Estado de ánimo (1-5)</label>
            <input type="number" name="mood" id="mood" min="1" max="5" class="border rounded w-full p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="comment">Comentario (opcional)</label>
            <textarea name="comment" id="comment" class="border rounded w-full p-2" rows="3"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Enviar
        </button>
    </form>

</div>
@endsection
