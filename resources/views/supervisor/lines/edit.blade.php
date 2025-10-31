@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Editar línea</h2>

<form method="POST" action="{{ route('supervisor.lines.update', $line) }}" class="bg-white p-4 shadow rounded">
    @csrf @method('PUT')
    <label class="block mb-2 font-medium">Código</label>
    <input type="text" value="{{ $line->code }}" class="w-full border rounded p-2 mb-4 bg-gray-100" disabled>

    <label class="block mb-2 font-medium">Nombre</label>
    <input type="text" name="name" value="{{ $line->name }}" class="w-full border rounded p-2 mb-4" required>

    <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1" {{ $line->is_active ? 'checked' : '' }}>
        <span class="ml-2">Activo</span>
    </label>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.lines.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
