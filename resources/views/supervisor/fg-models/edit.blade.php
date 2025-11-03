@extends('supervisor.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Editar modelo FG</h2>

<form method="POST" action="{{ route('supervisor.fg-models.update', $fgModel) }}" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <label class="block mb-2 font-medium">Código FG</label>
    <input type="text" value="{{ $fgModel->fg_code }}" class="w-full border rounded p-2 mb-4 bg-gray-100" disabled>

    <label class="block mb-2 font-medium">Descripción</label>
    <input type="text" name="description" value="{{ old('description', $fgModel->description) }}" class="w-full border rounded p-2 mb-4" required>

    <label class="inline-flex items-center mb-4">
        <input type="checkbox" name="is_active" value="1" {{ $fgModel->is_active ? 'checked' : '' }}class="mr-2">
        <span>Modelo activo</span>
    </label>

    <div class="mt-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('supervisor.fg-models.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </div>
</form>
@endsection
